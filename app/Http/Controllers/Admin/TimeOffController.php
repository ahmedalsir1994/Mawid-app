<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeOff;
use Illuminate\Http\Request;

class TimeOffController extends Controller
{
    public function index(Request $request)
    {
        $businessId = $request->user()->business_id;
        abort_if(!$businessId, 403);

        $items = TimeOff::where('business_id', $businessId)
            ->orderByDesc('start_date')
            ->get();

        return view('admin.time-off.index', compact('items'));
    }

    public function store(Request $request)
    {
        $businessId = $request->user()->business_id;
        abort_if(!$businessId, 403);

        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        TimeOff::create([
            'business_id' => $businessId,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'note' => $data['note'] ?? null,
        ]);

        return back()->with('success', 'Time off added.');
    }

    public function destroy(Request $request, TimeOff $timeOff)
    {
        abort_if($timeOff->business_id !== $request->user()->business_id, 403);

        $timeOff->delete();

        return back()->with('success', 'Time off deleted.');
    }
}