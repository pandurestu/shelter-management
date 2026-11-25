<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Shelter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        $viewType = $request->get('view', 'month'); // month, week, day
        $monthParam = $request->get('month', Carbon::now()->format('Y-m'));

        try {
            $currentDate = Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth();
        } catch (\Exception $e) {
            $currentDate = Carbon::now()->startOfMonth();
        }

        $prevMonth = $currentDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentDate->copy()->addMonth()->format('Y-m');

        // Shelter filter for calendar
        $shelterId = $request->get('shelter_id', 'all');

        $query = Schedule::with(['shelter', 'officer']);

        if ($shelterId !== 'all' && ! empty($shelterId)) {
            $query->where('shelter_id', $shelterId);
        }

        if ($viewType === 'month') {
            $startDate = $currentDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
            $endDate = $currentDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        } elseif ($viewType === 'week') {
            $selectedDay = $request->filled('date') ? Carbon::parse($request->date) : Carbon::today();
            $startDate = $selectedDay->copy()->startOfWeek(Carbon::MONDAY);
            $endDate = $selectedDay->copy()->endOfWeek(Carbon::SUNDAY);
        } else {
            // Day view
            $startDate = $request->filled('date') ? Carbon::parse($request->date)->startOfDay() : Carbon::today()->startOfDay();
            $endDate = $startDate->copy()->endOfDay();
        }

        $schedules = $query->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderBy('start_time', 'asc')
            ->get();

        // Group schedules by date
        $schedulesByDate = [];
        foreach ($schedules as $sched) {
            $dateKey = $sched->date->format('Y-m-d');
            $schedulesByDate[$dateKey][] = $sched;
        }

        // Generate calendar grid days for month view
        $calendarDays = [];
        $dayCursor = $startDate->copy();
        while ($dayCursor->lte($endDate)) {
            $calendarDays[] = [
                'date' => $dayCursor->copy(),
                'dateString' => $dayCursor->format('Y-m-d'),
                'dayNumber' => $dayCursor->day,
                'isCurrentMonth' => $dayCursor->month === $currentDate->month,
                'isToday' => $dayCursor->isToday(),
                'schedules' => $schedulesByDate[$dayCursor->format('Y-m-d')] ?? [],
            ];
            $dayCursor->addDay();
        }

        $shelters = Shelter::orderBy('name')->get();

        // Shelter color mapping generator
        $colors = [
            'emerald' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'blue' => 'bg-blue-100 text-blue-800 border-blue-300',
            'amber' => 'bg-amber-100 text-amber-800 border-amber-300',
            'purple' => 'bg-purple-100 text-purple-800 border-purple-300',
            'rose' => 'bg-rose-100 text-rose-800 border-rose-300',
            'teal' => 'bg-teal-100 text-teal-800 border-teal-300',
        ];

        return view('admin.calendar.index', compact(
            'viewType',
            'currentDate',
            'prevMonth',
            'nextMonth',
            'calendarDays',
            'shelters',
            'shelterId',
            'colors',
            'startDate',
            'endDate'
        ));
    }
}
