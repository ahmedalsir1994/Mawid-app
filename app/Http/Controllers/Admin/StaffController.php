<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $staff = User::where('business_id', $request->user()->business_id)
            ->where('role', 'staff')
            ->with('branch')
            ->paginate(20);
        
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $license = auth()->user()->business?->license;
        $canAdd  = $license ? $license->canAddStaff() : true;
        $plan    = $license ? ($license->plan ?? 'free') : 'free';

        if (!$canAdd) {
            return redirect()->route('admin.staff.index')
                ->with('limit_message', 'You have reached the maximum number of staff for your current plan. Upgrade to add more.');
        }

        try {
            $branches = auth()->user()->business->branches()->where('is_active', true)->orderBy('name')->get();
        } catch (\Exception $e) {
            $branches = collect();
        }

        return view('admin.staff.create', compact('canAdd', 'plan', 'license', 'branches'));
    }

    public function store(Request $request)
    {
        // Plan limit check
        $license = $request->user()->business->license;
        if ($license && !$license->canAddStaff()) {
            return redirect()->route('admin.upgrade.index')
                ->with('limit_hit', 'staff')
                ->with('limit_message', 'You have reached the maximum number of staff (' . $license->max_staff . ') for your current plan. Upgrade to add more.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'title'     => 'nullable|string|max:80',
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')->where('business_id', $request->user()->business_id)],
            'photo'     => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => $validated['password'],
            'title'       => $validated['title'] ?? null,
            'branch_id'   => $validated['branch_id'] ?? null,
            'role'        => 'staff',
            'business_id' => $request->user()->business_id,
            'is_active'   => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = 'staff_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/staff'), $name);
            $data['photo'] = 'uploads/staff/' . $name;
        }

        User::create($data);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member created successfully');
    }

    public function show(User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);

        $staff->load('branch');
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);

        try {
            $branches = auth()->user()->business->branches()->where('is_active', true)->orderBy('name')->get();
        } catch (\Exception $e) {
            $branches = collect();
        }

        return view('admin.staff.edit', compact('staff', 'branches'));
    }

    public function update(Request $request, User $staff)
    {
        abort_if($staff->business_id !== auth()->user()->business_id, 403);
        abort_if($staff->role !== 'staff', 403);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $staff->id,
            'title'     => 'nullable|string|max:80',
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')->where('business_id', $request->user()->business_id)],
            'photo'     => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'title'     => $validated['title'] ?? null,
            'branch_id' => $validated['branch_id'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'required|min:8|confirmed']);
            $data['password'] = $request->password;
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($staff->photo && file_exists(public_path($staff->photo))) {
                unlink(public_path($staff->photo));
            }
            $file = $request->file('photo');
            $name = 'staff_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/staff'), $name);
            $data['photo'] = 'uploads/staff/' . $name;
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
