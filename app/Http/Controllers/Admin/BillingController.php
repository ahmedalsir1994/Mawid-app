<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\License;
use App\Services\PlanService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Billing Overview
    // ─────────────────────────────────────────────────────────────────────────

    public function index()
    {
        $business = Auth::user()->business;

        if (!$business) {
            return redirect()->route('admin.company.dashboard')
                ->with('error', 'No business associated with your account.');
        }

        $license       = $business->license;
        $paymentMethod = $business->defaultPaymentMethod();
        $invoices      = $business->invoices()
            ->latest()
            ->paginate(10);

        return view('admin.billing.index', compact('business', 'license', 'paymentMethod', 'invoices'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Invoice View / Print
    // ─────────────────────────────────────────────────────────────────────────

    public function invoice(Invoice $invoice)
    {
        $business = Auth::user()->business;

        // Ensure the invoice belongs to the current business
        abort_if($invoice->business_id !== $business?->id, 403);

        return view('admin.billing.invoice', compact('invoice'));
    }

    public function downloadInvoice(Invoice $invoice)
    {
        $business = Auth::user()->business;
        abort_if($invoice->business_id !== $business?->id, 403);

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $html = view('admin.billing.invoice-pdf', compact('invoice'))->render();
            $pdf  = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');
            return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
        }

        // Fallback: open the printable view and trigger browser print dialog
        return redirect()->route('admin.billing.invoice', ['invoice' => $invoice->id, 'print' => 1]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Cancel Subscription → downgrade to Free
    // ─────────────────────────────────────────────────────────────────────────

    public function cancelSubscription(Request $request)
    {
        $business = Auth::user()->business;
        $license  = $business?->license;

        if (!$license || $license->plan === 'free') {
            return back()->with('error', 'No active paid subscription to cancel.');
        }

        // Downgrade to free plan immediately
        $license->update([
            'plan'               => 'free',
            'billing_cycle'      => 'monthly',   // enum cannot be null; reset to default
            'status'             => 'active',
            'payment_status'     => 'paid',
            'expires_at'         => null,
            'next_billing_date'  => null,
            'auto_renew'         => false,
            'auto_renew_attempts' => 0,
            'past_due_at'        => null,
            'grace_period_ends_at' => null,
            'max_branches'       => 1,
            'max_staff'          => 1,
            'max_services'       => 5,
            'max_users'          => 2,
            'max_daily_bookings' => 20,
            'whatsapp_reminders' => false,
        ]);

        return redirect()->route('admin.billing.index')
            ->with('success', 'Your subscription has been cancelled. Your account is now on the Free plan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Toggle Auto-Renew
    // ─────────────────────────────────────────────────────────────────────────

    public function toggleAutoRenew(Request $request)
    {
        $business = Auth::user()->business;
        $license  = $business?->license;

        if (!$license) {
            return back()->with('error', 'No license found.');
        }

        $license->update(['auto_renew' => !$license->auto_renew]);

        $status = $license->auto_renew ? 'enabled' : 'disabled';
        return back()->with('success', "Auto-renewal has been {$status}.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Initiate Card Update — 1 fil tokenisation (not a charge)
    // ─────────────────────────────────────────────────────────────────────────

    public function initiateCardUpdate(Request $request)
    {
        $user     = $request->user();
        $business = $user->business;
        $license  = $business?->license;

        if (!$license || !in_array($license->plan, ['pro', 'plus'])) {
            return back()->with('error', 'No active paid subscription to update the card for.');
        }

        $plan  = $license->plan;
        $cycle = $license->billing_cycle ?? 'monthly';

        // Use 1 fil (0.001 OMR) for card tokenisation — NOT the subscription amount.
        // callback will see update_card_only=true and skip plan activation.
        $orderRef = 'CARD-' . $user->business_id . '-' . Str::upper(Str::random(8));

        $http = Http::withToken(config('paymob.secret_key'));
        if (!config('paymob.verify_ssl')) {
            $http = $http->withoutVerifying();
        }

        try {
            $res = $http->post(config('paymob.base_url') . config('paymob.intention_path'), [
                'amount'            => 1,   // 1 fil = 0.001 OMR card-verification only
                'currency'          => config('paymob.currency'),
                'expiration'        => config('paymob.expiration'),
                'payment_methods'   => [(int) config('paymob.integration_id')],
                'special_reference' => $orderRef,
                'notification_url'  => route('paymob.callback'),
                'redirection_url'   => route('paymob.return'),
                'items'             => [[
                    'name'        => 'Card Verification — Mawid',
                    'amount'      => 1,
                    'description' => 'Card enrollment for auto-renewal. This is not a subscription charge.',
                    'quantity'    => 1,
                ]],
                'billing_data' => [
                    'first_name'   => $user->name,
                    'last_name'    => '.',
                    'email'        => $user->email,
                    'phone_number' => $user->phone ?? '+96800000000',
                    'country'      => 'OM',
                ],
                'extras' => ['save_card' => true],
            ]);
        } catch (ConnectionException $e) {
            return back()->with('error', 'Could not connect to payment gateway. Please try again.');
        }

        if (!$res->successful()) {
            return back()->with('error', 'Payment gateway error. Please try again.');
        }

        $clientSecret = $res->json('client_secret');
        $orderId      = $res->json('intention_order_id') ?? $res->json('order.id');
        $intentionId  = $res->json('id');

        if (empty($clientSecret)) {
            return back()->with('error', 'Payment gateway error: missing client secret.');
        }

        // Store as card-update-only. If license is past_due, flag for payment retry after card saved.
        $pending = [
            'plan'                     => $plan,
            'cycle'                    => $cycle,
            'business_id'              => $user->business_id,
            'update_card_only'         => true,
            'retry_after_card_update'  => $license->isPastDue(),
        ];
        Cache::put("paymob_ref_{$orderRef}", $pending, now()->addHours(2));
        if ($orderId)    Cache::put("paymob_order_{$orderId}", $pending, now()->addHours(2));
        if ($intentionId && $intentionId !== (string) $orderId)
            Cache::put("paymob_order_{$intentionId}", $pending, now()->addHours(2));

        $checkoutUrl = config('paymob.base_url') . config('paymob.checkout_path')
            . '?publicKey=' . urlencode(config('paymob.public_key'))
            . '&clientSecret=' . urlencode($clientSecret);

        return redirect()->away($checkoutUrl);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Retry Payment — create a fresh Paymob charge for the current plan
    // ─────────────────────────────────────────────────────────────────────────

    public function retryPayment(Request $request)
    {
        $user     = $request->user();
        $business = $user->business;
        $license  = $business?->license;

        if (!$license || !in_array($license->plan, ['pro', 'plus'])) {
            return back()->with('error', 'No active paid subscription to retry.');
        }

        if (!$license->isPastDue()) {
            return back()->with('error', 'Your subscription is not past due.');
        }

        $plan  = $license->plan;
        $cycle = $license->billing_cycle ?? 'monthly';
        $amount = PlanService::amountInFils($plan, $cycle);
        $orderRef = 'RETRY-' . $user->business_id . '-' . Str::upper(Str::random(8));

        $http = Http::withToken(config('paymob.secret_key'));
        if (!config('paymob.verify_ssl')) {
            $http = $http->withoutVerifying();
        }

        try {
            $res = $http->post(config('paymob.base_url') . config('paymob.intention_path'), [
                'amount'            => $amount,
                'currency'          => config('paymob.currency'),
                'expiration'        => config('paymob.expiration'),
                'payment_methods'   => [(int) config('paymob.integration_id')],
                'special_reference' => $orderRef,
                'notification_url'  => route('paymob.callback'),
                'redirection_url'   => route('paymob.return'),
                'items'             => [[
                    'name'        => 'Subscription Renewal — Mawid ' . ucfirst($plan),
                    'amount'      => $amount,
                    'description' => ucfirst($cycle) . ' subscription renewal',
                    'quantity'    => 1,
                ]],
                'billing_data' => [
                    'first_name'   => $user->name,
                    'last_name'    => '.',
                    'email'        => $user->email,
                    'phone_number' => $user->phone ?? '+96800000000',
                    'country'      => 'OM',
                ],
                'extras' => ['save_card' => true],
            ]);
        } catch (ConnectionException $e) {
            return back()->with('error', 'Could not connect to payment gateway. Please try again.');
        }

        if (!$res->successful()) {
            return back()->with('error', 'Payment gateway error. Please try again.');
        }

        $clientSecret = $res->json('client_secret');
        $orderId      = $res->json('intention_order_id') ?? $res->json('order.id');
        $intentionId  = $res->json('id');

        if (empty($clientSecret)) {
            return back()->with('error', 'Payment gateway error: missing client secret.');
        }

        $pending = ['plan' => $plan, 'cycle' => $cycle, 'business_id' => $user->business_id, 'is_retry' => true];
        Cache::put("paymob_ref_{$orderRef}", $pending, now()->addHours(2));
        if ($orderId)    Cache::put("paymob_order_{$orderId}", $pending, now()->addHours(2));
        if ($intentionId && $intentionId !== (string) $orderId)
            Cache::put("paymob_order_{$intentionId}", $pending, now()->addHours(2));

        $checkoutUrl = config('paymob.base_url') . config('paymob.checkout_path')
            . '?publicKey=' . urlencode(config('paymob.public_key'))
            . '&clientSecret=' . urlencode($clientSecret);

        return redirect()->away($checkoutUrl);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Remove Payment Method
    // ─────────────────────────────────────────────────────────────────────────

    public function removePaymentMethod()
    {
        $business = Auth::user()->business;

        $pm = $business?->defaultPaymentMethod();
        if ($pm) {
            $pm->delete();
            // Disable auto-renew since there's no longer a saved card
            $business->license?->update(['auto_renew' => false]);
        }

        return back()->with('success', 'Payment method removed. Auto-renewal has been disabled.');
    }
}
