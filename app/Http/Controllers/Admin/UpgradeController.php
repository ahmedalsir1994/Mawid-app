<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UpgradeController extends Controller
{
    /** Show the upgrade / plan selection page */
    public function index(Request $request)
    {
        $user     = $request->user();
        $business = $user->business;
        $license  = $business->license;
        $plans    = PlanService::all();

        // Pre-select plan from query param (coming from landing page for logged-in users)
        $preselectedPlan = $request->query('plan');

        $limitHit     = session('limit_hit');
        $limitMessage = session('limit_message');

        return view('admin.upgrade.index', compact(
            'license', 'business', 'plans', 'limitHit', 'limitMessage', 'preselectedPlan'
        ));
    }

    /**
     * Auto-initiate payment after email verification for users who registered
     * via a paid plan CTA. Reads plan/cycle from session.
     */
    public function autoPay(Request $request)
    {
        // Query params are the primary source (set by OtpVerificationController redirect).
        // Session is a fallback for backward compatibility.
        $plan  = $request->query('plan');
        $cycle = $request->query('cycle', 'monthly');

        if (!$plan || !in_array($plan, ['pro', 'plus'])) {
            $pending = $request->session()->get('pending_plan_upgrade');
            $plan    = $pending['plan']  ?? null;
            $cycle   = $pending['cycle'] ?? 'monthly';
        }

        // Clear session entry regardless
        $request->session()->forget('pending_plan_upgrade');

        if (!$plan || !in_array($plan, ['pro', 'plus'])) {
            return redirect()->route('admin.upgrade.index')
                ->with('error', 'No pending plan found. Please select a plan to upgrade.');
        }

        return $this->initiatePayment($request, $plan, $cycle);
    }

    /** Initiate a payment with Paymob (Intention API) — called from form POST */
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'plan'          => 'required|in:pro,plus',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        return $this->initiatePayment($request, $validated['plan'], $validated['billing_cycle']);
    }

    /** Core Paymob payment initiation shared by initiate() and autoPay() */
    private function initiatePayment(Request $request, string $plan, string $cycle)
    {
        $user = $request->user();

        $amountCents = PlanService::amountInFils($plan, $cycle); // OMR in baisa (1 OMR = 1000)

        if ($amountCents <= 0) {
            return back()->with('error', 'Invalid plan selected.');
        }

        // ── Build unique order reference ───────────────────────────────────
        $orderRef = 'ORD-' . $user->business_id . '-' . Str::upper(Str::random(8));

        // ── Create Intention (single API call) ─────────────────────────────
        $http = Http::withToken(config('paymob.secret_key'));
        if (!config('paymob.verify_ssl')) {
            $http = $http->withoutVerifying();
        }
        $intentionRes = $http->post(config('paymob.base_url') . config('paymob.intention_path'), [
                'amount'            => $amountCents,
                'currency'          => config('paymob.currency'),
                'expiration'        => config('paymob.expiration'),
                'payment_methods'   => [(int) config('paymob.integration_id')],
                'special_reference' => $orderRef,
                'notification_url'  => route('paymob.callback'),
                'redirection_url'   => route('paymob.return'),
                'items'             => [
                    [
                        'name'        => 'Mawid ' . ucfirst($plan) . ' (' . $cycle . ')',
                        'amount'      => $amountCents,
                        'description' => ucfirst($plan) . ' plan - ' . $cycle,
                        'quantity'    => 1,
                    ],
                ],
                'billing_data' => [
                    'first_name'   => $user->name,
                    'last_name'    => '.',
                    'email'        => $user->email,
                    'phone_number' => $user->phone ?? '+96800000000',
                    'country'      => 'OM',
                ],
            ]);

        if (!$intentionRes->successful()) {
            Log::error('Paymob: Intention creation failed', [
                'status'   => $intentionRes->status(),
                'response' => $intentionRes->json(),
            ]);
            return back()->with('error', 'Payment gateway error. Please try again.');
        }

        $clientSecret = $intentionRes->json('client_secret');
        $orderId      = $intentionRes->json('intention_order_id')
                     ?? $intentionRes->json('order.id');
        $intentionId  = $intentionRes->json('id');

        if (empty($clientSecret)) {
            Log::error('Paymob: No client_secret in response', ['response' => $intentionRes->json()]);
            return back()->with('error', 'Payment gateway error. Please try again.');
        }

        // ── Cache pending plan — store under all possible lookup keys ─────
        $pendingData = [
            'plan'        => $plan,
            'cycle'       => $cycle,
            'business_id' => $user->business_id,
        ];
        Cache::put("paymob_ref_{$orderRef}", $pendingData, now()->addHours(2));
        if ($orderId) {
            Cache::put("paymob_order_{$orderId}", $pendingData, now()->addHours(2));
        }
        if ($intentionId && $intentionId !== (string) $orderId) {
            Cache::put("paymob_order_{$intentionId}", $pendingData, now()->addHours(2));
        }

        // ── Clear the session pending upgrade now that we have a live payment ──
        $request->session()->forget('pending_plan_upgrade');

        // ── Redirect to Unified Checkout ───────────────────────────────────
        $checkoutUrl = config('paymob.base_url') . config('paymob.checkout_path')
            . '?publicKey=' . urlencode(config('paymob.public_key'))
            . '&clientSecret=' . urlencode($clientSecret);

        return redirect()->away($checkoutUrl);
    }
}
