<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperAdminLicenseController extends Controller
{
    public function index()
    {
        $licenses = License::with('business')->paginate(15);
        return view('admin.super.licenses.index', compact('licenses'));
    }

    public function create()
    {
        $businesses = Business::doesntHave('license')->get();
        return view('admin.super.licenses.create', compact('businesses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id|unique:licenses,business_id',
            'license_key' => 'required|unique:licenses',
            'status' => 'required|in:active,expired,suspended,cancelled',
            'max_users' => 'required|integer|min:1',
            'max_daily_bookings' => 'required|integer|min:1',
            'expires_at' => 'required|date|after:today',
            'price' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,unpaid',
            'notes' => 'nullable|string',
        ]);

        $validated['activated_at'] = now();

        License::create($validated);

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
        return view('admin.super.licenses.edit', compact('license', 'businesses'));
    }

    public function update(Request $request, License $license)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,expired,suspended,cancelled',
            'max_users' => 'required|integer|min:1',
            'max_daily_bookings' => 'required|integer|min:1',
            'expires_at' => 'required|date',
            'price' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,unpaid',
            'notes' => 'nullable|string',
        ]);

        $license->update($validated);

        return redirect()->route('admin.super.licenses.show', $license)
            ->with('success', 'License updated successfully');
    }

    public function destroy(License $license)
    {
        // Licenses should never be deleted - just mark as cancelled
        return redirect()->route('admin.super.licenses.show', $license)
            ->with('error', 'Licenses cannot be deleted. Please mark as cancelled instead.');
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
