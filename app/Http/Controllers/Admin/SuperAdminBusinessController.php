<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\License;
use Illuminate\Http\Request;

class SuperAdminBusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::with('license', 'users')->paginate(15);
        return view('admin.super.businesses.index', compact('businesses'));
    }

    public function create()
    {
        return view('admin.super.businesses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:businesses',
            'address' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'currency' => 'required|string',
            'timezone' => 'required|string',
        ]);

        Business::create($data);

        return redirect()->route('admin.super.businesses.index')
            ->with('success', 'Business created successfully');
    }

    public function show(Business $business)
    {
        $business->load('users', 'license', 'bookings', 'services');
        return view('admin.super.businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        return view('admin.super.businesses.edit', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
        $business->update($request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'is_active' => 'boolean',
        ]));

        return redirect()->route('admin.super.businesses.show', $business)
            ->with('success', 'Business updated successfully');
    }

    public function destroy(Business $business)
    {
        $business->delete();
        return redirect()->route('admin.super.businesses.index')
            ->with('success', 'Business deleted successfully');
    }
}
