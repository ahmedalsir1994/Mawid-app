<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $businessId = $request->user()->business_id;

        $services = Service::where('business_id', $businessId)
            ->orderBy('name')
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $businessId = $request->user()->business_id;

        abort_if(!$businessId, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', Rule::in(['on'])], // checkbox
        ]);

        $serviceData = [
            'business_id' => $businessId,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'duration_minutes' => (int)$data['duration_minutes'],
            'price' => $data['price'] ?? null,
            'is_active' => isset($data['is_active']),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'service_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $imageName);
            $serviceData['image'] = 'uploads/services/' . $imageName;
        }

        Service::create($serviceData);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Request $request, Service $service)
    {
        $this->authorizeService($request, $service);

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $this->authorizeService($request, $service);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', Rule::in(['on'])],
        ]);

        $serviceData = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'duration_minutes' => (int)$data['duration_minutes'],
            'price' => $data['price'] ?? null,
            'is_active' => isset($data['is_active']),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }
            
            $image = $request->file('image');
            $imageName = 'service_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $imageName);
            $serviceData['image'] = 'uploads/services/' . $imageName;
        }

        $service->update($serviceData);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Request $request, Service $service)
    {
        $this->authorizeService($request, $service);

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function authorizeService(Request $request, Service $service): void
    {
        abort_if($service->business_id !== $request->user()->business_id, 403);
    }
}