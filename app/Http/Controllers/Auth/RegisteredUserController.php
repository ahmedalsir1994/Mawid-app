<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Models\User;
use App\Models\Business;
use App\Models\License;
use App\Mail\OtpVerificationMail;
use App\Notifications\NewUserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile'        => ['required', 'string', 'max:20'],
            'business_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:100'],
            'company_size'  => ['required', 'string', 'in:1-5,6-20,21-50,51-200,200+'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'plan'          => ['nullable', 'in:free,pro,plus'],
            'billing_cycle' => ['nullable', 'in:monthly,yearly'],
        ]);

        // Create a business for the new user
        $business = Business::create([
            'name'          => $request->business_name,
            'slug'          => Str::slug($request->business_name . '-' . Str::random(6)),
            'mobile'        => $request->mobile,
            'business_type' => $request->business_type,
            'company_size'  => $request->company_size,
            'country'       => 'OM',
            'currency'      => 'OMR',
            'timezone'      => 'Asia/Muscat',
        ]);

        // Create user with company_admin role and assign business
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company_admin',
            'business_id' => $business->id,
        ]);

        // Create a Free plan license for the business (no expiry)
        License::create([
            'business_id'        => $business->id,
            'license_key'        => 'FREE-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(12)),
            'plan'               => 'free',
            'billing_cycle'      => 'monthly',
            'status'             => 'active',
            'max_users'          => 2,  // owner + 1 staff
            'max_daily_bookings' => 50,
            'max_branches'       => 1,
            'max_staff'          => 1,
            'max_services'       => 3,
            'whatsapp_reminders' => false,
            'activated_at'       => now(),
            'expires_at'         => null, // Free plan never expires
            'price'              => 0,
            'payment_status'     => 'paid',
            'notes'              => 'Free plan - auto-created on registration',
        ]);

        event(new Registered($user));

        // Notify all super admins about the new registration
        $superAdmins = User::where('role', 'super_admin')->get();
        Notification::send($superAdmins, new NewUserRegisteredNotification($user, $business));

        // If a paid plan was selected, store it on the user record so it survives session loss
        $plan  = $request->input('plan');
        $cycle = $request->input('billing_cycle', 'monthly');
        if ($plan && in_array($plan, ['pro', 'plus'])) {
            $user->update([
                'pending_plan'  => $plan,
                'pending_cycle' => $cycle,
            ]);
        }

        // Generate OTP, save to user, send email
        [$otp] = OtpVerificationController::generateAndSaveOtp($user);
        Mail::to($user->email)->send(new OtpVerificationMail($otp, $user->name));

        // Store user ID in session for the OTP step (user is NOT logged in yet)
        $request->session()->put('otp_user_id', $user->id);

        return redirect()->route('otp.show')
            ->with('info', 'We sent a 6-digit verification code to ' . $user->email);
    }
}