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
            'images'              => ['nullable', 'array', 'max:10'],
            'images.*'            => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
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

        // Image minimum guards
        $newCount = $request->hasFile('images') ? count($request->file('images')) : 0;
        $serviceCount = Service::where('business_id', $businessId)->count();
        if ($serviceCount === 0) {
            // This is the first service being created
            if ($newCount < 3) {
                return back()
                    ->withErrors(['images' => 'If you have only one service, you must upload at least 3 images for it.'])
                    ->withInput();
            }
        } else {
            if ($newCount < 1) {
                return back()
                    ->withErrors(['images' => 'Please upload at least 1 photo for this service.'])
                    ->withInput();
            }
            $existingTotal = ServiceImage::whereIn(
                'service_id',
                Service::where('business_id', $businessId)->pluck('id')
            )->count();
            if ($existingTotal + $newCount < 3) {
                $needed = 3 - $existingTotal - $newCount;
                return back()
                    ->withErrors(['images' => "You need at least 3 photos total across all your services. Please add {$needed} more photo(s)."])
                    ->withInput();
            }
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
            'images'              => ['nullable', 'array', 'max:10'],
            'images.*'            => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'description'         => ['nullable', 'string', 'max:1000'],
            'duration_minutes'    => ['required', 'integer', 'min:15', 'max:480', function ($attribute, $value, $fail) {
                if ($value % 15 !== 0) {
                    $fail('Duration must be a multiple of 15 minutes (e.g. 15, 30, 45, 60, 75, 90, 120…).');
                }
            }],
            'price'               => ['nullable', 'numeric', 'min:0'],
            'is_active'           => ['nullable', Rule::in(['on'])],
            'branch_ids'          => ['nullable', 'array'],
            'branch_ids.*'        => ['integer', Rule::exists('branches', 'id')->where('business_id', $service->business_id)],
        ]);

        // Image minimum guards
        $service->loadMissing('images');
        $existingImgCount = $service->images->count();
        $newCount = $request->hasFile('images') ? count($request->file('images')) : 0;
        $afterThis = $existingImgCount + $newCount;
        if ($afterThis < 1) {
            return back()
                ->withErrors(['images' => 'This service must have at least 1 photo.'])
                ->withInput();
        }
        $totalOther = ServiceImage::whereIn(
            'service_id',
            Service::where('business_id', $service->business_id)->where('id', '!=', $service->id)->pluck('id')
        )->count();
        if ($totalOther + $afterThis < 3) {
            $needed = 3 - $totalOther - $afterThis;
            return back()
                ->withErrors(['images' => "You need at least 3 photos total across all your services. Please add {$needed} more photo(s)."])
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

        // Minimum image guards
        $remainingOnService = $service->images()->where('id', '!=', $serviceImage->id)->count();
        if ($remainingOnService < 1) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Each service must have at least 1 photo.'], 422);
            }
            return back()->with('error', 'Each service must have at least 1 photo.');
        }
        $totalAfterDelete = ServiceImage::whereIn(
            'service_id',
            Service::where('business_id', $service->business_id)->pluck('id')
        )->count() - 1;
        if ($totalAfterDelete < 3) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You must keep at least 3 photos total across all your services.'], 422);
            }
            return back()->with('error', 'You must keep at least 3 photos total across all your services.');
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