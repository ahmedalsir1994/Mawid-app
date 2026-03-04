<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Business;
use App\Models\User;
use App\Notifications\NewLicenseCreatedNotification;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class SuperAdminLicenseController extends Controller
{
    public function index(Request $request)
    {
        $query = License::with('business');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('license_key', 'like', "%{$search}%")
                  ->orWhereHas('business', fn ($b) => $b
                      ->where('name', 'like', "%{$search}%")
                  );
            });
        }

        if ($plan = $request->input('plan')) {
            $query->where('plan', $plan);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($payment = $request->input('payment')) {
            $query->where('payment_status', $payment);
        }

        $licenses = $query->latest()->paginate(15)->withQueryString();
        return view('admin.super.licenses.index', compact('licenses'));
    }

    public function create()
    {
        $businesses = Business::doesntHave('license')->get();
        $plans      = PlanService::all();
        return view('admin.super.licenses.create', compact('businesses', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id'        => 'required|exists:businesses,id|unique:licenses,business_id',
            'license_key'        => 'required|unique:licenses',
            'plan'               => 'required|in:free,pro,plus',
            'billing_cycle'      => 'required|in:monthly,yearly',
            'status'             => 'required|in:active,expired,suspended,cancelled',
            'payment_status'     => 'required|in:paid,unpaid',
            'expires_at'         => 'nullable|date',
            'price'              => 'required|numeric|min:0',
            'max_branches'       => 'required|integer|min:1',
            'max_staff'          => 'required|integer|min:1',
            'max_services'       => 'required|integer|min:0',
            'whatsapp_reminders' => 'boolean',
            'notes'              => 'nullable|string',
        ]);

        $planDef = PlanService::get($validated['plan']);
        $validated['activated_at']      = now();
        $validated['max_daily_bookings'] = $planDef['max_daily_bookings'] ?? 50;
        $validated['max_users']          = $validated['max_staff'];
        $validated['whatsapp_reminders'] = $request->boolean('whatsapp_reminders');

        // Auto-calculate expires_at if not manually provided
        if (empty($validated['expires_at'])) {
            $validated['expires_at'] = $validated['plan'] === 'free'
                ? now()->addYears(100)
                : ($validated['billing_cycle'] === 'yearly' ? now()->addYear() : now()->addMonth());
        }

        $license = License::create($validated);

        // Notify all super admins
        $superAdmins = User::where('role', 'super_admin')->get();
        Notification::send($superAdmins, new NewLicenseCreatedNotification($license->load('business')));

        return redirect()->route('admin.super.licenses.index')
            ->with('success', 'License created successfully');
    }

    public function show(License $license)
    {
        return view('admin.super.licenses.show', compact('license'));
    }

    public function edit(License $license)
    {
        $businesses = Business::where('id', $license->business_id)
            ->orWhereDoesntHave('license')
            ->get();
        $plans = PlanService::all();
        return view('admin.super.licenses.edit', compact('license', 'businesses', 'plans'));
    }

    public function update(Request $request, License $license)
    {
        $validated = $request->validate([
            'plan'               => 'required|in:free,pro,plus',
            'billing_cycle'      => 'required|in:monthly,yearly',
            'status'             => 'required|in:active,expired,suspended,cancelled',
            'payment_status'     => 'required|in:paid,unpaid',
            'expires_at'         => 'nullable|date',
            'price'              => 'required|numeric|min:0',
            'max_branches'       => 'required|integer|min:1',
            'max_staff'          => 'required|integer|min:1',
            'max_services'       => 'required|integer|min:0',
            'whatsapp_reminders' => 'boolean',
            'notes'              => 'nullable|string',
        ]);

        $planDef = PlanService::get($validated['plan']);
        $validated['max_daily_bookings'] = $planDef['max_daily_bookings'] ?? 50;
        $validated['max_users']          = $validated['max_staff'];
        $validated['whatsapp_reminders'] = $request->boolean('whatsapp_reminders');

        if (empty($validated['expires_at'])) {
            $validated['expires_at'] = $validated['plan'] === 'free'
                ? now()->addYears(100)
                : ($validated['billing_cycle'] === 'yearly' ? now()->addYear() : now()->addMonth());
        }

        $license->update($validated);

        return redirect()->route('admin.super.licenses.show', $license)
            ->with('success', 'License updated successfully');
    }

    public function destroy(License $license)
    {
        $businessName = $license->business->name ?? 'Unknown';
        $license->delete();

        return redirect()->route('admin.super.licenses.index')
            ->with('success', "License for \"{$businessName}\" deleted successfully.");
    }

    public function reactivate(License $license)
    {
        $license->update([
            'status' => 'active',
            'payment_status' => 'paid',
        ]);

        return redirect()->route('admin.super.licenses.show', $license)
            ->with('success', 'License reactivated successfully!');
    }

    public function generateKey()
    {
        return 'LIC-' . strtoupper(Str::random(20));
    }
}
