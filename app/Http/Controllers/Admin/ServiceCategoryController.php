<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function index(Request $request)
    {
        $businessId = $request->user()->business_id;
        $categories = ServiceCategory::where('business_id', $businessId)->orderBy('name')->get();
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $businessId = $request->user()->business_id;
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);
        ServiceCategory::create([
            'name' => $request->name,
            'business_id' => $businessId,
        ]);
        return redirect()->route('admin.service_categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        abort_if($serviceCategory->business_id !== auth()->user()->business_id, 403);
        return view('admin.service_categories.edit', ['category' => $serviceCategory]);
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        abort_if($serviceCategory->business_id !== auth()->user()->business_id, 403);
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);
        $serviceCategory->update(['name' => $request->name]);
        return redirect()->route('admin.service_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        abort_if($serviceCategory->business_id !== auth()->user()->business_id, 403);
        $serviceCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}
