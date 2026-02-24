<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use App\Models\License;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create a business for the new user
        $business = Business::create([
            'name' => $request->name . "'s Business",
            'slug' => Str::slug($request->name . '-' . Str::random(6)),
            'email' => $request->email,
            'country' => 'OM', // Default country
            'currency' => 'OMR', // Default currency
            'timezone' => 'Asia/Muscat', // Default timezone
        ]);

        // Create user with company_admin role and assign business
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company_admin',
            'business_id' => $business->id,
        ]);

        // Create a 14-day trial license for the business
        $expiresAt = now()->addDays(14);
        License::create([
            'business_id' => $business->id,
            'license_key' => 'TRIAL-' . Str::upper(Str::random(12)),
            'status' => 'active',
            'max_users' => 5,
            'max_daily_bookings' => 999,
            'activated_at' => now(),
            'expires_at' => $expiresAt,
            'price' => 0,
            'payment_status' => 'paid',
            'notes' => '14-day trial license for new signup',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin.dashboard', absolute: false));
    }
}