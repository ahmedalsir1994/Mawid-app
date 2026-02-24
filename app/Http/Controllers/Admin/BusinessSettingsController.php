<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BusinessSettingsController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        // If the user has no business yet, create one quickly
        if (!$user->business_id) {
            $name = $user->name . ' Business';
            $business = Business::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::lower(Str::random(4)),
                'country' => 'OM',
                'timezone' => 'Asia/Muscat',
                'currency' => 'OMR',
                'default_language' => 'ar',
            ]);

            $user->business_id = $business->id;
            $user->save();
        }

        return view('admin.business.edit', [
            'business' => $user->business,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        abort_if(!$business, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => [
                'required', 'string', 'max:120',
                Rule::unique('businesses', 'slug')->ignore($business->id),
            ],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:2048'],
            'country' => ['required', Rule::in(['OM', 'SA'])],
            'timezone' => ['required', Rule::in(['Asia/Muscat', 'Asia/Riyadh'])],
            'currency' => ['required', Rule::in(['OMR', 'SAR'])],
            'default_language' => ['required', Rule::in(['ar', 'en'])],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($business->logo && file_exists(public_path($business->logo))) {
                unlink(public_path($business->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/logos'), $logoName);
            $data['logo'] = 'uploads/logos/' . $logoName;
        }

        // Small auto-fix: if country changes, suggest matching defaults (only if user didn't change them)
        if ($data['country'] === 'SA') {
            // If they still have Oman defaults, switch them to Saudi defaults
            if ($business->timezone === 'Asia/Muscat') $data['timezone'] = 'Asia/Riyadh';
            if ($business->currency === 'OMR') $data['currency'] = 'SAR';
        } else {
            if ($business->timezone === 'Asia/Riyadh') $data['timezone'] = 'Asia/Muscat';
            if ($business->currency === 'SAR') $data['currency'] = 'OMR';
        }

        $business->update($data);

        return back()->with('success', 'Business settings updated successfully.');
    }
}