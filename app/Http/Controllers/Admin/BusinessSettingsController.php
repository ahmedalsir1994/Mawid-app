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
                'default_language' => 'en',
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
            'logo'           => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:2048'],
            'gallery_image_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'gallery_image_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'gallery_image_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'country'              => ['required', 'string', 'size:2'],
            'timezone'             => ['required', 'timezone:all'],
            'currency'             => ['required', Rule::in(['OMR', 'SAR'])],
            'default_language'     => ['required', Rule::in(['ar', 'en'])],
            'phone'                => ['nullable', 'string', 'max:30'],
            'address'              => ['nullable', 'string', 'max:255'],
            'how_heard_about_us'   => ['nullable', 'string', 'max:60'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($business->logo && file_exists(public_path($business->logo))) {
                unlink(public_path($business->logo));
            }
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/logos'), $logoName);
            $data['logo'] = 'uploads/logos/' . $logoName;
        }

        // Handle gallery images (slots 1–3)
        $gallery = $business->gallery_images ?? [null, null, null];
        while (count($gallery) < 3) $gallery[] = null;

        foreach ([1, 2, 3] as $slot) {
            $field = "gallery_image_{$slot}";
            if ($request->hasFile($field)) {
                // Delete old slot image
                $old = $gallery[$slot - 1] ?? null;
                if ($old && file_exists(public_path($old))) {
                    unlink(public_path($old));
                }
                $file = $request->file($field);
                $name = 'gallery_' . $business->id . '_' . $slot . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/gallery'), $name);
                $gallery[$slot - 1] = 'uploads/gallery/' . $name;
            }
        }

        $data['gallery_images'] = $gallery;

        // Require all 3 gallery slots to be filled before saving
        $missing = [];
        foreach ([1, 2, 3] as $slot) {
            if (empty($gallery[$slot - 1])) $missing[] = $slot;
        }
        if (!empty($missing)) {
            return back()
                ->withErrors(['gallery' => 'All 3 gallery photos are required. Missing: Photo ' . implode(', ', $missing) . '.'])
                ->withInput();
        }

        // Remove keys that shouldn't go into Business::update directly
        unset($data['gallery_image_1'], $data['gallery_image_2'], $data['gallery_image_3']);

        $business->update($data);

        return back()->with('success', 'Business settings updated successfully.');
    }

    public function removeGalleryImage(Request $request, int $slot)
    {
        $user = $request->user();
        $business = $user->business;
        abort_if(!$business, 404);
        abort_if($slot < 1 || $slot > 3, 422);

        $gallery = $business->gallery_images ?? [null, null, null];
        while (count($gallery) < 3) $gallery[] = null;

        $path = $gallery[$slot - 1] ?? null;
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
        $gallery[$slot - 1] = null;

        $business->gallery_images = $gallery;
        $business->save();

        return response()->json(['ok' => true]);
    }
}