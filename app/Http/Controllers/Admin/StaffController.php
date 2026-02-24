<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $staff = User::where('business_id', $request->user()->business_id)
            ->where('role', 'staff')
            ->paginate(20);
        
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'business_id' => $request->user()->business_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member created successfully');
    }

    public function show(User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);
        
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);
        
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.show', $staff)
            ->with('success', 'Staff member updated successfully');
    }

    public function destroy(User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);

        $staff->delete();
        
        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully');
    }
}
