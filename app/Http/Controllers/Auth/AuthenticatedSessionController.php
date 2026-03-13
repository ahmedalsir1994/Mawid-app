<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\OtpVerificationMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): \Illuminate\Http\Response
    {
        return response(view('auth.login'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // Block unverified accounts — send them back to OTP verification
        if (! $user->email_verified_at) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Generate a fresh OTP (the old one may have expired)
            [$otp] = OtpVerificationController::generateAndSaveOtp($user);
            try {
                Mail::to($user->email)->send(new OtpVerificationMail($otp, $user->name));
            } catch (\Exception $e) {
                // Non-fatal — user still sees the OTP form and can use resend
            }

            $request->session()->put('otp_user_id', $user->id);

            return redirect()->route('otp.show')
                ->with('info', 'Please verify your email before logging in. A new code has been sent to ' . $user->email . '.');
        }

        // If redirected from session expired, go to intended
        $intended = $request->input('intended');
        if ($intended) {
            return redirect()->to($intended);
        }

        // Redirect based on user role
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.super.dashboard');
        } elseif ($user->role === 'company_admin') {
            return redirect()->route('admin.company.dashboard');
        } elseif ($user->role === 'staff') {
            return redirect()->route('admin.staff.dashboard');
        }
        // Default redirect for customer
        return redirect()->route('profile.edit');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}