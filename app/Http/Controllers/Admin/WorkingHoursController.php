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
                ['first_shift_start' => '09:00', 'first_shift_end' => '18:00', 'is_closed' => false]
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
            'hours.*.first_shift_start' => ['nullable'],
            'hours.*.first_shift_end' => ['nullable'],
            'hours.*.second_shift_start' => ['nullable'],
            'hours.*.second_shift_end' => ['nullable'],
        ]);

        foreach ($request->input('hours') as $dow => $row) {
            $isClosed = isset($row['is_closed']);

            $firstStart = $isClosed ? null : ($row['first_shift_start'] ?? null);
            $firstEnd   = $isClosed ? null : ($row['first_shift_end'] ?? null);
            $secondStart = $isClosed ? null : ($row['second_shift_start'] ?? null);
            $secondEnd   = $isClosed ? null : ($row['second_shift_end'] ?? null);

            // Optional: basic sanity check for both shifts
            if (!$isClosed && $firstStart && $firstEnd && $firstStart >= $firstEnd) {
                return back()
                    ->withErrors(["hours.$dow.first_shift_end" => "First shift end time must be after start time for day $dow"])
                    ->withInput();
            }
            if (!$isClosed && $secondStart && $secondEnd && $secondStart >= $secondEnd) {
                return back()
                    ->withErrors(["hours.$dow.second_shift_end" => "Second shift end time must be after start time for day $dow"])
                    ->withInput();
            }

            WorkingHour::updateOrCreate(
                ['business_id' => $businessId, 'day_of_week' => (int)$dow],
                [
                    'first_shift_start' => $firstStart,
                    'first_shift_end' => $firstEnd,
                    'second_shift_start' => $secondStart,
                    'second_shift_end' => $secondEnd,
                    'is_closed' => $isClosed
                ]
            );
        }

        return back()->with('success', 'Working hours updated.');
    }
}