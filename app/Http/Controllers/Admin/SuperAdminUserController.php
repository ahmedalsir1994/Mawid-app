<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;

class SuperAdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('business')->paginate(20);
        return view('admin.super.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User();
        $businesses = Business::all();
        $roles = ['super_admin', 'company_admin', 'staff', 'customer'];
        return view('admin.super.users.create', compact('user', 'businesses', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:super_admin,company_admin,staff,customer',
            'business_id' => 'nullable|exists:businesses,id',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.super.users.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('admin.super.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $businesses = Business::all();
        $roles = ['super_admin', 'company_admin', 'staff', 'customer'];
        return view('admin.super.users.edit', compact('user', 'businesses', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,company_admin,staff,customer',
            'business_id' => 'nullable|exists:businesses,id',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.super.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.super.users.index')
            ->with('success', 'User deleted successfully');
    }
}
