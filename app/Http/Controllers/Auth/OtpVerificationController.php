<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP entry form.
     */
    public function show(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('otp_user_id')) {
            return redirect()->route('register');
        }

        return view('auth.otp-verify');
    }

    /**
     * Verify the submitted OTP.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = $request->session()->get('otp_user_id');

        if (! $userId) {
            return redirect()->route('register')
                ->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        $user = User::findOrFail($userId);

        // Check expiry
        if (! $user->otp_expires_at || now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'The verification code has expired. Please request a new one.']);
        }

        // Check match
        if ($request->otp !== $user->otp_code) {
            return back()->withErrors(['otp' => 'Invalid verification code. Please try again.']);
        }

        // Mark verified — clear OTP, set email_verified_at
        $user->update([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
        ]);

        $request->session()->forget('otp_user_id');

        Auth::login($user);

        // If a paid plan was selected before registration, auto-initiate payment
        if ($request->session()->has('pending_plan_upgrade')) {
            $pending = $request->session()->get('pending_plan_upgrade');
            Mail::to($user->email)->send(new WelcomeMail($user, $pending['plan'], pendingPayment: true));
            return redirect()->route('admin.upgrade.autopay', [
                'plan'  => $pending['plan'],
                'cycle' => $pending['cycle'] ?? 'monthly',
            ])->with('success', 'Email verified! Redirecting you to payment...');
        }

        Mail::to($user->email)->send(new WelcomeMail($user, 'free'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Your email has been verified. Welcome to ' . config('app.name') . '!');
    }

    /**
     * Resend a fresh OTP.
     */
    public function resend(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('otp_user_id');

        if (! $userId) {
            return redirect()->route('register');
        }

        $user = User::findOrFail($userId);

        [$otp] = $this->generateAndSaveOtp($user);

        Mail::to($user->email)->send(new OtpVerificationMail($otp, $user->name));

        return back()->with('resent', 'A new verification code has been sent to ' . $user->email);
    }

    /**
     * Generate a 6-digit OTP, persist it on the user, return [otp].
     */
    public static function generateAndSaveOtp(User $user): array
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        return [$otp];
    }
}
