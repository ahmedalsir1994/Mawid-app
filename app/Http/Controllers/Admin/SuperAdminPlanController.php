<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SuperAdminPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.super.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.super.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlan($request);
        $validated['whatsapp_reminders'] = $request->boolean('whatsapp_reminders');
        $validated['is_featured']        = $request->boolean('is_featured');
        $validated['is_active']          = $request->boolean('is_active', true);
        $validated['features']           = $this->parseFeatures($request->input('features_text', ''));

        Plan::create($validated);
        Cache::forget('landing_plans');

        return redirect()->route('admin.super.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.super.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $this->validatePlan($request, $plan);
        $validated['whatsapp_reminders'] = $request->boolean('whatsapp_reminders');
        $validated['is_featured']        = $request->boolean('is_featured');
        $validated['is_active']          = $request->boolean('is_active', true);
        $validated['features']           = $this->parseFeatures($request->input('features_text', ''));

        $plan->update($validated);
        Cache::forget('landing_plans');

        return redirect()->route('admin.super.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        // Prevent deleting a plan that has active licenses
        if ($plan->licenses()->count() > 0) {
            return redirect()->route('admin.super.plans.index')
                ->with('error', "Cannot delete \"{$plan->name}\" — it has active licenses. Disable the plan instead.");
        }

        $plan->delete();
        Cache::forget('landing_plans');

        return redirect()->route('admin.super.plans.index')
            ->with('success', 'Plan deleted.');
    }

    public function toggle(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);
        Cache::forget('landing_plans');

        $state = $plan->is_active ? 'enabled' : 'disabled';
        return redirect()->route('admin.super.plans.index')
            ->with('success', "Plan \"{$plan->name}\" has been {$state}.");
    }

    // ───────────────────────────────────────────────────────────────────────

    private function validatePlan(Request $request, ?Plan $plan = null): array
    {
        $slugUnique = 'unique:plans,slug';
        if ($plan) {
            $slugUnique .= ',' . $plan->id;
        }

        return $request->validate([
            'slug'                  => "required|alpha_dash|max:20|{$slugUnique}",
            'name'                  => 'required|string|max:50',
            'emoji'                 => 'required|string|max:10',
            'tagline'               => 'nullable|string|max:200',
            'price_monthly'         => 'required|numeric|min:0',
            'price_yearly'          => 'required|numeric|min:0',
            'price_monthly_display' => 'nullable|numeric|min:0',
            'price_yearly_display'  => 'nullable|numeric|min:0',
            'old_price_monthly'     => 'nullable|numeric|min:0',
            'old_price_yearly'      => 'nullable|numeric|min:0',
            'discount_monthly'      => 'nullable|integer|min:0|max:100',
            'discount_yearly'       => 'nullable|integer|min:0|max:100',
            'max_branches'          => 'required|integer|min:1',
            'max_staff'             => 'required|integer|min:1',
            'max_services'          => 'required|integer|min:0',
            'max_daily_bookings'    => 'required|integer|min:0',
            'max_monthly_bookings'  => 'nullable|integer|min:0',
            'sort_order'            => 'nullable|integer|min:0',
            'featured_label'        => 'nullable|string|max:50',
            'cta_label'             => 'nullable|string|max:100',
            'accent_color'          => 'nullable|in:gray,blue,green,purple,orange',
        ]);
    }

    private function parseFeatures(string $text): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode("\n", str_replace("\r", '', $text)))
            )
        );
    }
}
