<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\License;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymobController extends Controller
{
    /**
     * Paymob Transaction Callback (server-to-server POST)
     * Paymob sends this to /paymob/callback
     * Must be excluded from CSRF middleware (see bootstrap/app.php or VerifyCsrfToken)
     */
    public function callback(Request $request)
    {
        $data = $request->all();

        // Verify HMAC signature
        if (!$this->verifyHmac($data)) {
            Log::warning('Paymob: Invalid HMAC', ['data' => $data]);
            return response()->json(['status' => 'invalid hmac'], 403);
        }

        // Support both old API (transaction nested under 'obj') and new Intention API (flat)
        $obj            = $data['obj'] ?? $data;
        $success        = filter_var($obj['success'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $orderId        = $obj['order']['id'] ?? null;
        $paymobOrderId  = (string) $orderId;
        $merchantRef    = $obj['merchant_order_id']
                       ?? $obj['order']['merchant_order_id']
                       ?? null;
        $txId           = (string) ($obj['id'] ?? '');

        if (!$success) {
            return response()->json(['status' => 'ignored']);
        }

        // Retrieve the pending plan data — try order ID first, then merchant reference
        $pending = ($paymobOrderId ? Cache::get("paymob_order_{$paymobOrderId}") : null)
                ?? ($merchantRef   ? Cache::get("paymob_ref_{$merchantRef}")     : null);

        if (!$pending) {
            Log::warning('Paymob: No pending order in cache', [
                'order_id'     => $paymobOrderId,
                'merchant_ref' => $merchantRef,
            ]);
            return response()->json(['status' => 'no pending order']);
        }

        $license = License::where('business_id', $pending['business_id'])->first();

        if (!$license) {
            Log::error('Paymob: License not found for business', $pending);
            return response()->json(['status' => 'license not found'], 404);
        }

        if (!empty($pending['update_card_only'])) {
            // Card-update flow: save the new token, skip plan activation
            $this->saveCardToken($license, $obj);
            Cache::forget("paymob_order_{$paymobOrderId}");
            if ($merchantRef) Cache::forget("paymob_ref_{$merchantRef}");
            Log::info('Paymob: Card updated', ['business_id' => $pending['business_id']]);
            return response()->json(['status' => 'card_updated']);
        }

        $license->applyPlan($pending['plan'], $pending['cycle'], $paymobOrderId ?: $merchantRef, $txId ?? null);

        // Save card token for auto-renewal
        $this->saveCardToken($license, $obj);

        Cache::forget("paymob_order_{$paymobOrderId}");
        if ($merchantRef) {
            Cache::forget("paymob_ref_{$merchantRef}");
        }

        $logContext = ['business_id' => $pending['business_id'], 'plan' => $pending['plan'], 'cycle' => $pending['cycle']];
        Log::info('Paymob: Plan upgraded', $logContext);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Paymob redirect return URL (user is sent here after payment).
     * Acts as a fallback plan activator in case the server-side callback
     * could not reach the server (e.g. localhost dev, firewall, etc.).
     */
    public function return(Request $request)
    {
        $success = filter_var($request->input('success'), FILTER_VALIDATE_BOOLEAN);

        if (!$success) {
            return redirect()->route('admin.upgrade.index')
                ->with('error', 'Payment was not completed. Please try again.');
        }

        $merchantRef   = $request->input('merchant_order_id');
        $paymobOrderId = (string) $request->input('order');

        $pending = ($paymobOrderId ? Cache::get("paymob_order_{$paymobOrderId}") : null)
                ?? ($merchantRef   ? Cache::get("paymob_ref_{$merchantRef}")     : null);

        if ($pending) {
            if (!empty($pending['update_card_only'])) {
                // Card tokenisation: save token, skip plan activation
                Cache::forget("paymob_order_{$paymobOrderId}");
                if ($merchantRef) Cache::forget("paymob_ref_{$merchantRef}");

                if (!empty($pending['retry_after_card_update'])) {
                    // Account is past_due — prompt the user to complete payment now
                    return redirect()->route('admin.billing.index')
                        ->with('card_updated_retry', true)
                        ->with('success', '✓ Card saved! Please click "Retry Payment" below to restore your subscription.');
                }

                return redirect()->route('admin.billing.index')
                    ->with('success', '✓ Your payment card has been updated successfully.');
            }

            $license = License::where('business_id', $pending['business_id'])->first();
            // Determine if this is a reactivation (expired/past-due same plan) before applying
            $isReactivation = $license && ($license->isExpired() || $license->isPastDue());
            // Apply plan if it differs, OR if this is a renewal/retry, OR if the license is expired/past-due (reactivation)
            if ($license && ($license->plan !== $pending['plan'] || !empty($pending['is_retry']) || $isReactivation)) {
                $license->applyPlan($pending['plan'], $pending['cycle'], $paymobOrderId ?: $merchantRef);
                Cache::forget("paymob_order_{$paymobOrderId}");
                if ($merchantRef) Cache::forget("paymob_ref_{$merchantRef}");
                Log::info('Paymob return: Plan applied via fallback', $pending);
            }
        }

        $planName = ($pending && isset($pending['plan'])) ? $pending['plan'] : null;
        if (!$planName) {
            $planName = auth()->user()?->business?->license?->plan ?? 'pro';
        }
        $isRetryOrReactivation = !empty($pending['is_retry']) || ($isReactivation ?? false);
        if ($pdAuthUser = auth()->user()) {
            // Only send welcome mail for upgrades, not retries/renewals/reactivations
            if (!$isRetryOrReactivation) {
                Mail::to($pdAuthUser->email)->send(new WelcomeMail($pdAuthUser, $planName, pendingPayment: false));
            }
        }

        $successMsg = $isRetryOrReactivation
            ? '✓ Payment successful! Your subscription has been restored.'
            : '🎉 Payment successful! Your plan has been upgraded.';

        return redirect()->route('admin.dashboard')->with('success', $successMsg);
    }

    // ────────────────────────────────────────────────────────────────────
    // Card Token Storage
    // ────────────────────────────────────────────────────────────────────

    private function saveCardToken(License $license, array $obj): void
    {
        // ── Structured debug log — never log raw token values ─────────────
        Log::info('Paymob saveCardToken: field presence check', [
            'business_id'      => $license->business_id,
            'has_token'        => isset($obj['token']),
            'has_card_token'   => isset($obj['card_token']),
            'has_source_token' => isset($obj['source_data']['token']),
            'source_type'      => $obj['source_data']['type']     ?? null,
            'source_sub_type'  => $obj['source_data']['sub_type'] ?? null,
            'has_pan'          => isset($obj['source_data']['pan']),
            'has_expiry_month' => isset($obj['expiry_month'])  || isset($obj['card_expiry_month']),
            'has_expiry_year'  => isset($obj['expiry_year'])   || isset($obj['card_expiry_year']),
        ]);

        // ── Token extraction ───────────────────────────────────────────────
        $token = $obj['token']
            ?? $obj['card_token']
            ?? $obj['source_data']['token']
            ?? $obj['payment_key_claims']['token']
            ?? null;

        if (!$token) {
            Log::warning('Paymob saveCardToken: no token found, skipping card save', [
                'business_id' => $license->business_id,
            ]);
            return;
        }

        // ── Card metadata (non-sensitive display data only) ────────────────
        $srcType  = $obj['source_data']['type']     ?? null;
        $srcSub   = $obj['source_data']['sub_type'] ?? null;
        $rawBrand = $srcSub ?: $srcType;

        $rawLastFour = $obj['source_data']['pan']
            ?? $obj['card_number']
            ?? null;

        $expMonth = $obj['expiry_month']
            ?? $obj['card_expiry_month']
            ?? $obj['source_data']['expiry_month']
            ?? null;
        $expYear  = $obj['expiry_year']
            ?? $obj['card_expiry_year']
            ?? $obj['source_data']['expiry_year']
            ?? null;

        if ($expYear && strlen((string)$expYear) === 2) {
            $expYear = '20' . $expYear;
        }

        $firstName = $obj['billing_data']['first_name'] ?? null;
        $lastName  = $obj['billing_data']['last_name']  ?? null;
        $rawHolder = trim(($firstName ?? '') . ' ' . ($lastName ?? '')) ?: null;
        if ($rawHolder === '.') $rawHolder = null;

        // ── Sanitize before persisting ─────────────────────────────────────
        $brand    = PaymentMethod::sanitizeBrand($rawBrand);
        $lastFour = PaymentMethod::sanitizeLastFour((string) $rawLastFour);
        $holder   = PaymentMethod::sanitizeName($rawHolder);

        // ── Upsert — token is encrypted at rest via 'encrypted' cast ───────
        PaymentMethod::updateOrCreate(
            ['business_id' => $license->business_id],
            [
                'paymob_token'    => $token,   // encrypted by cast
                'card_brand'      => $brand,
                'last_four'       => $lastFour,
                'expiry_month'    => $expMonth,
                'expiry_year'     => $expYear,
                'cardholder_name' => $holder,
                'is_default'      => true,
            ]
        );

        $license->update(['auto_renew' => true]);

        Log::info('Paymob: Card saved successfully', [
            'business_id' => $license->business_id,
            'brand'       => $brand,
            'last_four'   => $lastFour ? '****' . $lastFour : null,
            'expiry'      => $expMonth && $expYear ? "{$expMonth}/" . substr($expYear, -2) : null,
        ]);

        Log::info('Paymob: Card token saved', ['business_id' => $license->business_id]);
    }

    // ────────────────────────────────────────────────────────────────────
    // HMAC Verification
    // ────────────────────────────────────────────────────────────────────

    private function verifyHmac(array $data): bool
    {
        $hmacSecret = config('paymob.hmac_secret');

        if (empty($hmacSecret)) {
            Log::critical('Paymob HMAC secret is not configured — callback accepted without verification. Set PAYMOB_HMAC_SECRET in .env immediately.');
            // Only skip in local environment; reject in production
            return app()->environment('local', 'testing');
        }

        // Support both old API (transaction nested under 'obj') and new Intention API (flat)
        $obj = $data['obj'] ?? $data;

        // Paymob HMAC string fields (in exact order)
        $hmacFields = [
            'amount_cents', 'created_at', 'currency', 'error_occured',
            'has_parent_transaction', 'id', 'integration_id',
            'is_3d_secure', 'is_auth', 'is_capture', 'is_refunded',
            'is_standalone_payment', 'is_voided',
            'order.id', 'owner', 'pending', 'source_data.pan',
            'source_data.sub_type', 'source_data.type', 'success',
        ];

        $concatenated = '';
        foreach ($hmacFields as $field) {
            if (str_contains($field, '.')) {
                [$parent, $child] = explode('.', $field);
                $concatenated .= ($obj[$parent][$child] ?? '') ;
            } else {
                $val = $obj[$field] ?? '';
                if (is_bool($val)) {
                    $val = $val ? 'true' : 'false';
                }
                $concatenated .= $val;
            }
        }

        $expected = hash_hmac('sha512', $concatenated, $hmacSecret);
        // HMAC may arrive as a query param (new Intention API) or in the body (old API)
        $received = $data['hmac'] ?? '';

        return hash_equals($expected, $received);
    }
}
