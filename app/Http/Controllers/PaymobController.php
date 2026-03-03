<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\License;
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

        $license->applyPlan($pending['plan'], $pending['cycle'], $paymobOrderId ?: $merchantRef);
        Cache::forget("paymob_order_{$paymobOrderId}");
        if ($merchantRef) {
            Cache::forget("paymob_ref_{$merchantRef}");
        }

        Log::info('Paymob: Plan upgraded', [
            'business_id' => $pending['business_id'],
            'plan'        => $pending['plan'],
            'cycle'       => $pending['cycle'],
        ]);

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

        // ── Try to apply the plan from cache (fallback for when the
        //    server-side callback never reached us) ─────────────────────────
        $merchantRef   = $request->input('merchant_order_id');  // our ORD-x-xxx ref
        $paymobOrderId = (string) $request->input('order');     // numeric order id

        $pending = ($paymobOrderId ? Cache::get("paymob_order_{$paymobOrderId}") : null)
                ?? ($merchantRef   ? Cache::get("paymob_ref_{$merchantRef}")     : null);

        if ($pending) {
            $license = License::where('business_id', $pending['business_id'])->first();
            if ($license && $license->plan !== $pending['plan']) {
                $license->applyPlan($pending['plan'], $pending['cycle'], $paymobOrderId ?: $merchantRef);
                Cache::forget("paymob_order_{$paymobOrderId}");
                if ($merchantRef) Cache::forget("paymob_ref_{$merchantRef}");
                Log::info('Paymob return: Plan applied via fallback', $pending);
            }
        }

        // Send welcome / plan-activated confirmation email
        $planName = ($pending && isset($pending['plan'])) ? $pending['plan'] : null;
        if (!$planName) {
            $planName = auth()->user()?->business?->license?->plan ?? 'pro';
        }
        if ($authUser = auth()->user()) {
            Mail::to($authUser->email)->send(new WelcomeMail($authUser, $planName, pendingPayment: false));
        }

        return redirect()->route('admin.dashboard')
            ->with('success', '🎉 Payment successful! Your plan has been upgraded.');
    }

    // ────────────────────────────────────────────────────────────────────
    // HMAC Verification
    // ────────────────────────────────────────────────────────────────────

    private function verifyHmac(array $data): bool
    {
        $hmacSecret = config('paymob.hmac_secret');

        if (empty($hmacSecret)) {
            return true; // Skip during development if not configured
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
