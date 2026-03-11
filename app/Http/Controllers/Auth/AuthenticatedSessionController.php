<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // If redirected from session expired, go to intended
        $intended = $request->input('intended');
        if ($intended) {
            return redirect()->to($intended);
        }

        // Redirect based on user role
        $user = auth()->user();
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