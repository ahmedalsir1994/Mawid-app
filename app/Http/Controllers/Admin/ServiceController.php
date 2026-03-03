<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $businessId = $request->user()->business_id;

        $services = Service::where('business_id', $businessId)
            ->with('images')
            ->orderBy('name')
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $business = auth()->user()->business;
        $license  = $business->license ?? null;
        $canAdd   = $license ? $license->canAddService() : true;
        $plan     = $license ? ($license->plan ?? 'free') : 'free';
        $branches = $business->branches()->where('is_active', true)->orderBy('name')->get();
        return view('admin.services.create', compact('canAdd', 'plan', 'license', 'branches'));
    }

    public function store(Request $request)
    {
        $businessId = $request->user()->business_id;

        abort_if(!$businessId, 403);

        // Plan limit check
        $license = $request->user()->business->license;
        if ($license && !$license->canAddService()) {
            return redirect()->route('admin.upgrade.index')
                ->with('limit_hit', 'services')
                ->with('limit_message', 'You have reached the maximum number of services (' . $license->max_services . ') for your current plan. Upgrade to add more.');
        }

        $data = $request->validate([
            'name'             => ['required', 'string', 'max:120'],
            'images'           => ['nullable', 'array', 'max:10'],
            'images.*'         => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'description'      => ['nullable', 'string', 'max:1000'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:480', function ($attribute, $value, $fail) {
                if ($value % 15 !== 0) {
                    $fail('Duration must be a multiple of 15 minutes (e.g. 15, 30, 45, 60, 75, 90, 120…).');
                }
            }],
            'price'            => ['nullable', 'numeric', 'min:0'],
            'is_active'        => ['nullable', Rule::in(['on'])],
            'branch_ids'       => ['nullable', 'array'],
            'branch_ids.*'     => ['integer', Rule::exists('branches', 'id')->where('business_id', $businessId)],
        ]);

        $service = Service::create([
            'business_id'      => $businessId,
            'name'             => $data['name'],
            'description'      => $data['description'] ?? null,
            'duration_minutes' => (int) $data['duration_minutes'],
            'price'            => $data['price'] ?? null,
            'is_active'        => isset($data['is_active']),
        ]);

        $service->branches()->sync($data['branch_ids'] ?? []);

        $this->storeImages($request, $service);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Request $request, Service $service)
    {
        $this->authorizeService($request, $service);

        $service->load('images', 'branches');

        $branches = $request->user()->business->branches()->where('is_active', true)->orderBy('name')->get();

        return view('admin.services.edit', compact('service', 'branches'));
    }

    public function update(Request $request, Service $service)
    {
        $this->authorizeService($request, $service);

        $data = $request->validate([
            'name'              => ['required', 'string', 'max:120'],
            'images'            => ['nullable', 'array', 'max:10'],
            'images.*'          => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'description'       => ['nullable', 'string', 'max:1000'],
            'duration_minutes'  => ['required', 'integer', 'min:15', 'max:480', function ($attribute, $value, $fail) {
                if ($value % 15 !== 0) {
                    $fail('Duration must be a multiple of 15 minutes (e.g. 15, 30, 45, 60, 75, 90, 120…).');
                }
            }],
            'price'             => ['nullable', 'numeric', 'min:0'],
            'is_active'         => ['nullable', Rule::in(['on'])],
            'branch_ids'        => ['nullable', 'array'],
            'branch_ids.*'      => ['integer', Rule::exists('branches', 'id')->where('business_id', $service->business_id)],
        ]);

        $service->update([
            'name'             => $data['name'],
            'description'      => $data['description'] ?? null,
            'duration_minutes' => (int) $data['duration_minutes'],
            'price'            => $data['price'] ?? null,
            'is_active'        => isset($data['is_active']),
        ]);

        $service->branches()->sync($data['branch_ids'] ?? []);

        $this->storeImages($request, $service);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Request $request, Service $service)
    {
        $this->authorizeService($request, $service);

        // Delete physical image files
        foreach ($service->images as $img) {
            if (file_exists(public_path($img->path))) {
                unlink(public_path($img->path));
            }
        }
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    /**
     * Delete a single service image.
     */
    public function destroyImage(Request $request, Service $service, ServiceImage $serviceImage)
    {
        $this->authorizeService($request, $service);

        abort_if($serviceImage->service_id !== $service->id, 403);

        if (file_exists(public_path($serviceImage->path))) {
            unlink(public_path($serviceImage->path));
        }

        $serviceImage->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Image removed.');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function storeImages(Request $request, Service $service): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $sort = $service->images()->max('sort_order') ?? -1;

        foreach ($request->file('images') as $file) {
            $name = 'service_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/services'), $name);
            $service->images()->create([
                'path'       => 'uploads/services/' . $name,
                'sort_order' => ++$sort,
            ]);
        }
    }

    private function authorizeService(Request $request, Service $service): void
    {
        abort_if($service->business_id !== $request->user()->business_id, 403);
    }
}