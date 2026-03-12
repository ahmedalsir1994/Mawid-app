<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'company_admin')
            ->with(['business.license'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('business', fn ($b) => $b->where('name', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%")
                      ->orWhere('business_type', 'like', "%{$search}%")
                  );
            });
        }

        if ($request->filled('plan')) {
            $query->whereHas('business.license', fn ($q) => $q->where('plan', $request->plan));
        }

        if ($request->filled('status')) {
            $query->whereHas('business.license', fn ($q) => $q->where('status', $request->status));
        }

        if ($request->filled('business_type')) {
            $query->whereHas('business', fn ($q) => $q->where('business_type', $request->business_type));
        }

        $registrations = $query->paginate(20)->withQueryString();
        $total = User::where('role', 'company_admin')->count();

        return view('admin.super.registrations.index', compact('registrations', 'total'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'company_admin', 404);

        $user->load(['business.license', 'business.branches', 'business.bookings', 'business.users']);

        return view('admin.super.registrations.show', compact('user'));
    }
}
