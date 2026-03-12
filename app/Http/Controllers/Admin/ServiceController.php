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
            'name'                => ['required', 'string', 'max:120'],
            'service_category_id' => ['nullable', 'integer', Rule::exists('service_categories', 'id')->where('business_id', $businessId)],
            'images'              => ['nullable', 'array', 'max:3'],
            'images.*'            => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'description'         => ['nullable', 'string', 'max:1000'],
            'duration_minutes'    => ['required', 'integer', 'min:15', 'max:480', function ($attribute, $value, $fail) {
                if ($value % 15 !== 0) {
                    $fail('Duration must be a multiple of 15 minutes (e.g. 15, 30, 45, 60, 75, 90, 120…).');
                }
            }],
            'price'               => ['nullable', 'numeric', 'min:0'],
            'is_active'           => ['nullable', Rule::in(['on'])],
            'branch_ids'          => ['nullable', 'array'],
            'branch_ids.*'        => ['integer', Rule::exists('branches', 'id')->where('business_id', $businessId)],
        ]);

        if (!$request->hasFile('images') || count($request->file('images')) < 1) {
            return back()
                ->withErrors(['images' => 'Please upload at least 1 photo for this service.'])
                ->withInput();
        }

        $service = Service::create([
            'business_id'        => $businessId,
            'name'               => $data['name'],
            'service_category_id'=> $data['service_category_id'] ?? null,
            'description'        => $data['description'] ?? null,
            'duration_minutes'   => (int) $data['duration_minutes'],
            'price'              => $data['price'] ?? null,
            'is_active'          => isset($data['is_active']),
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
            'name'                => ['required', 'string', 'max:120'],
            'service_category_id' => ['nullable', 'integer', Rule::exists('service_categories', 'id')->where('business_id', $service->business_id)],
            'images'              => ['nullable', 'array', 'max:3'],
            'images.*'            => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'description'         => ['nullable', 'string', 'max:1000'],
            'duration_minutes'    => ['required', 'integer', 'min:15', 'max:480', function ($attribute, $value, $fail) {
                if ($value % 15 !== 0) {
                    $fail('Duration must be a multiple of 15 minutes (e.g. 15, 30, 45, 60, 75, 90, 120…)');
                }
            }],
            'price'               => ['nullable', 'numeric', 'min:0'],
            'is_active'           => ['nullable', Rule::in(['on'])],
            'branch_ids'          => ['nullable', 'array'],
            'branch_ids.*'        => ['integer', Rule::exists('branches', 'id')->where('business_id', $service->business_id)],
        ]);

        // Enforce max 3 images per service (check existing + new combined)
        $service->loadMissing('images');
        $existingImgCount = $service->images->count();
        $newCount = $request->hasFile('images') ? count($request->file('images')) : 0;
        if ($existingImgCount + $newCount > 3) {
            return back()
                ->withErrors(['images' => 'A service can have at most 3 photos. You already have ' . $existingImgCount . ' — please upload at most ' . (3 - $existingImgCount) . ' more.'])
                ->withInput();
        }

        $service->update([
            'name'                => $data['name'],
            'service_category_id' => $data['service_category_id'] ?? null,
            'description'         => $data['description'] ?? null,
            'duration_minutes'    => (int) $data['duration_minutes'],
            'price'               => $data['price'] ?? null,
            'is_active'           => isset($data['is_active']),
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

        // Ensure each service keeps at least 1 photo
        $remainingOnService = $service->images()->where('id', '!=', $serviceImage->id)->count();
        if ($remainingOnService < 1) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Each service must keep at least 1 photo.'], 422);
            }
            return back()->with('error', 'Each service must keep at least 1 photo.');
        }

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
        $remaining = 3 - $service->images()->count();

        foreach ($request->file('images') as $file) {
            if ($remaining <= 0) break;
            $name = 'service_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/services'), $name);
            $service->images()->create([
                'path'       => 'uploads/services/' . $name,
                'sort_order' => ++$sort,
            ]);
            $remaining--;
        }
    }

    private function authorizeService(Request $request, Service $service): void
    {
        abort_if($service->business_id !== $request->user()->business_id, 403);
    }
}