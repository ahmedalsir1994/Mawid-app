<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user      = Auth::user();
        $business  = $user->business;
        $license   = $business?->license;
        $branches  = $business ? $business->branches()->withCount(['services', 'staff'])->get() : collect();

        return view('admin.branches.index', compact('business', 'license', 'branches'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $license = $user->business?->license;
        $canAdd  = $license ? $license->canAddBranch() : false;

        if (!$canAdd) {
            return redirect()->route('admin.branches.index')
                ->with('limit_message', __('app.branch_limit_reached'));
        }

        return view('admin.branches.create', compact('license', 'canAdd'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user    = $request->user();
        $license = $user->business?->license;
        if ($license && !$license->canAddBranch()) {
            return redirect()->route('admin.upgrade.index')
                ->with('limit_message', 'You have reached the maximum number of branches (' . $license->max_branches . ') for your current plan.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string|max:500',
            'phone'     => 'nullable|string|max:30',
            'is_active' => 'boolean',
        ]);

        $branch = $user->business->branches()->create([
            'name'      => $validated['name'],
            'address'   => $validated['address'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_main'   => $user->business->branches()->count() === 0,
        ]);

        return redirect()->route('admin.branches.index')
            ->with('success', __('app.branch_created'));
    }

    public function show(Branch $branch)
    {
        $this->authoriseBranch($branch);

        $branch->load(['services', 'staff']);

        /** @var \App\Models\User $user */
        $user        = Auth::user();
        $allServices = $user->business->services()->where('is_active', true)->get();
        $license     = $user->business?->license;

        return view('admin.branches.show', compact('branch', 'allServices', 'license'));
    }

    public function edit(Branch $branch)
    {
        $this->authoriseBranch($branch);

        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $license = $user->business?->license;
        return view('admin.branches.edit', compact('branch', 'license'));
    }

    public function update(Request $request, Branch $branch)
    {
        $this->authoriseBranch($branch);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string|max:500',
            'phone'     => 'nullable|string|max:30',
            'is_active' => 'boolean',
        ]);

        $branch->update([
            'name'      => $validated['name'],
            'address'   => $validated['address'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.branches.show', $branch)
            ->with('success', __('app.branch_updated'));
    }

    public function destroy(Branch $branch)
    {
        $this->authoriseBranch($branch);

        if ($branch->is_main) {
            return back()->with('error', __('app.cannot_delete_main_branch'));
        }

        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', __('app.branch_deleted'));
    }

    /**
     * Sync services assigned to a branch.
     */
    public function syncServices(Request $request, Branch $branch)
    {
        $this->authoriseBranch($branch);

        $request->validate([
            'services'   => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Only allow services that belong to this business
        $businessServiceIds = $user->business
            ->services()
            ->pluck('id')
            ->toArray();

        $selectedIds = array_filter(
            $request->input('services', []),
            fn($id) => in_array($id, $businessServiceIds)
        );

        $branch->services()->sync($selectedIds);

        return back()->with('success', __('app.branch_services_updated'));
    }

    // ---------- Helpers ----------

    private function authoriseBranch(Branch $branch): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_unless(
            $branch->business_id === $user->business_id,
            403
        );
    }
}
