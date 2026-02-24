<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the request and redirect based on user role
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.super.dashboard');
        } elseif ($user->role === 'company_admin') {
            return redirect()->route('admin.company.dashboard');
        } elseif ($user->role === 'staff') {
            return redirect()->route('admin.staff.dashboard');
        }
        
        return redirect()->route('profile.edit');
    }
}
