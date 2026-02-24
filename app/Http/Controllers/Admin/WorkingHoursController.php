<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkingHour;
use Illuminate\Http\Request;

class WorkingHoursController extends Controller
{
    private array $days = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    public function edit(Request $request)
    {
        $businessId = $request->user()->business_id;
        abort_if(!$businessId, 403);

        // Ensure 7 rows exist (one per day)
        foreach (array_keys($this->days) as $dow) {
            WorkingHour::firstOrCreate(
                ['business_id' => $businessId, 'day_of_week' => $dow],
                ['start_time' => '09:00', 'end_time' => '18:00', 'is_closed' => false]
            );
        }

        $hours = WorkingHour::where('business_id', $businessId)
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        return view('admin.working-hours.edit', [
            'days' => $this->days,
            'hours' => $hours,
        ]);
    }

    public function update(Request $request)
    {
        $businessId = $request->user()->business_id;
        abort_if(!$businessId, 403);

        $request->validate([
            'hours' => ['required', 'array'],
            'hours.*.is_closed' => ['nullable'],
            'hours.*.start_time' => ['nullable'],
            'hours.*.end_time' => ['nullable'],
        ]);

        foreach ($request->input('hours') as $dow => $row) {
            $isClosed = isset($row['is_closed']);

            $start = $isClosed ? null : ($row['start_time'] ?? null);
            $end   = $isClosed ? null : ($row['end_time'] ?? null);

            // Optional: basic sanity check
            if (!$isClosed && $start && $end && $start >= $end) {
                return back()
                    ->withErrors(["hours.$dow.end_time" => "End time must be after start time for day $dow"])
                    ->withInput();
            }

            WorkingHour::updateOrCreate(
                ['business_id' => $businessId, 'day_of_week' => (int)$dow],
                ['start_time' => $start, 'end_time' => $end, 'is_closed' => $isClosed]
            );
        }

        return back()->with('success', 'Working hours updated.');
    }
}