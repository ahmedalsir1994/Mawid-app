<?php

namespace App\Jobs;

use App\Mail\SubscriptionRenewedMail;
use App\Models\Invoice;
use App\Models\License;
use App\Models\PaymentMethod;
use App\Notifications\AutoRenewFailedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\PlanService;

class AutoRenewSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;
    public int $timeout = 120;

    public function handle(PlanService $planService): void
    {
        $licenses = License::with(['business.paymentMethods', 'business.users'])
            ->where('auto_renew', true)
            ->whereIn('status', ['active', 'past_due'])
            ->whereNotNull('next_billing_date')
            ->whereDate('next_billing_date', '<=', today())
            ->where(function ($q) {
                // Retry past_due up to 3 attempts; always process active
                $q->where('status', 'active')
                  ->orWhere(function ($q2) {
                      $q2->where('status', 'past_due')
                         ->where('auto_renew_attempts', '<', 3);
                  });
            })
            ->get();

        Log::info("AutoRenew: Found {$licenses->count()} license(s) due for renewal.");

        foreach ($licenses as $license) {
            $this->renewLicense($license, $planService);
        }
    }

    private function renewLicense(License $license, PlanService $planService): void
    {
        $business = $license->business;
        if (!$business) {
            Log::warning("AutoRenew: License {$license->id} has no business.");
            return;
        }

        $paymentMethod = $business->defaultPaymentMethod();
        if (!$paymentMethod) {
            Log::warning("AutoRenew: Business {$business->id} has no saved payment method.");
            $this->handleFailure($license, 'No saved payment method');
            return;
        }

        $plan  = $license->plan;
        $cycle = $license->billing_cycle ?? 'monthly';

        if (in_array($plan, ['free', null])) {
            Log::info("AutoRenew: License {$license->id} is free — skipping.");
            return;
        }

        $amountCents = (int) round($planService->price($plan, $cycle) * 100);

        // ── Paymob: Create order + pay with token ──────────────────────────
        $http = Http::withToken(config('paymob.secret_key'));
        if (!config('paymob.verify_ssl')) {
            $http = $http->withoutVerifying();
        }

        $orderRef = 'AUTO-' . $license->id . '-' . now()->format('Ymd');

        try {
            $intentionRes = $http->post(config('paymob.base_url') . config('paymob.intention_path'), [
                'amount'            => $amountCents,
                'currency'          => config('paymob.currency'),
                'expiration'        => 3600,
                'payment_methods'   => [(int) config('paymob.integration_id')],
                'special_reference' => $orderRef,
                'notification_url'  => route('paymob.callback'),
                'redirection_url'   => route('paymob.return'),
                'card_tokens'       => [$paymentMethod->paymob_token],
                'items'             => [
                    [
                        'name'        => 'Mawid ' . ucfirst($plan) . ' (' . $cycle . ') — Auto Renewal',
                        'amount'      => $amountCents,
                        'description' => 'Auto-renewal',
                        'quantity'    => 1,
                    ],
                ],
                'billing_data' => [
                    'first_name'   => $business->name,
                    'last_name'    => '.',
                    'email'        => $business->users()->first()?->email ?? 'unknown@email.com',
                    'phone_number' => '+96800000000',
                    'country'      => 'OM',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error("AutoRenew: HTTP error for license {$license->id}", ['msg' => $e->getMessage()]);
            $this->handleFailure($license, 'Connection error: ' . $e->getMessage());
            return;
        }

        if (!$intentionRes->successful()) {
            Log::error("AutoRenew: Intention failed for license {$license->id}", $intentionRes->json() ?? []);
            $this->handleFailure($license, 'Paymob intention failed');
            return;
        }

        // ── Pay immediately using token ────────────────────────────────────
        $clientSecret = $intentionRes->json('client_secret');
        $orderId      = $intentionRes->json('intention_order_id') ?? $intentionRes->json('order.id');
        $intentionId  = $intentionRes->json('id');

        if (!$clientSecret) {
            $this->handleFailure($license, 'No client_secret returned');
            return;
        }

        // Pay with token (recurring charge)
        try {
            $payRes = $http->post(config('paymob.base_url') . '/v1/intention/pay-with-token', [
                'intention_id' => $intentionId,
                'token'        => $paymentMethod->paymob_token,
            ]);
        } catch (\Exception $e) {
            Log::error("AutoRenew: Pay-with-token error for license {$license->id}", ['msg' => $e->getMessage()]);
            $this->handleFailure($license, 'Pay-with-token error: ' . $e->getMessage());
            return;
        }

        $txSuccess = filter_var($payRes->json('success') ?? $payRes->json('obj.success') ?? false, FILTER_VALIDATE_BOOLEAN);
        $txId      = (string) ($payRes->json('id') ?? $payRes->json('obj.id') ?? '');

        if (!$txSuccess) {
            Log::warning("AutoRenew: Payment failed for license {$license->id}", $payRes->json() ?? []);
            $this->handleFailure($license, 'Payment declined');
            return;
        }

        // ── Success — update license & create invoice ──────────────────────
        $license->applyPlan($plan, $cycle, (string) $orderId, $txId);

        Log::info("AutoRenew: License {$license->id} renewed successfully. Next billing: {$license->next_billing_date}");

        // Send renewal confirmation email with invoice PDF attached
        $admin   = $business->users()->where('role', 'company_admin')->first();
        $invoice = $license->latestInvoice;
        if ($admin && $invoice) {
            try {
                Mail::to($admin->email)->send(new SubscriptionRenewedMail($invoice, $admin));
                Log::info("AutoRenew: Renewal email sent to {$admin->email} for license {$license->id}");
            } catch (\Throwable $e) {
                Log::warning("AutoRenew: Could not send renewal email for license {$license->id}", ['error' => $e->getMessage()]);
            }
        }
    }

    private function handleFailure(License $license, string $reason): void
    {
        $attempts = ($license->auto_renew_attempts ?? 0) + 1;

        $license->update([
            'auto_renew_attempts' => $attempts,
            'past_due_at'         => $license->past_due_at ?? now(),
        ]);

        // On the first failure, start the 5-day grace period and send PaymentFailedMail.
        // On subsequent failures we keep the original grace window — don't reset it.
        if ($license->status !== 'past_due') {
            $license->markPastDue($reason);
        }

        // Also dispatch the admin in-app notification
        $admin = $license->business?->users()->where('role', 'company_admin')->first();
        if ($admin) {
            $admin->notify(new AutoRenewFailedNotification($license, $reason));
        }

        Log::warning("AutoRenew: Failure for license {$license->id} (attempt #{$attempts}). Reason: {$reason}");

        // After 3 failed attempts, disable auto-renew to stop hammering
        if ($attempts >= 3) {
            $license->update(['auto_renew' => false]);
            Log::warning("AutoRenew: Disabled auto-renew for license {$license->id} after 3 failures.");
        }
    }
}
