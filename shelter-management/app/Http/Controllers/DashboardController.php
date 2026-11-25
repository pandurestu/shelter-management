<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Officer;
use App\Models\Schedule;
use App\Models\Shelter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today();

        // 1. Key Metrics
        $totalShelters = Shelter::count();
        $activeSheltersCount = Shelter::where('status', 'Aktif')->count();
        $totalCapacity = (int) Shelter::sum('capacity');
        $totalOfficers = Officer::count();
        $activeOfficersCount = Officer::where('status', 'Aktif')->count();
        $standbyOfficersCount = Officer::where('status', 'Siaga')->count();
        $totalSchedules = Schedule::where('status', '!=', 'Dibatalkan')->count();
        $todaySchedulesCount = Schedule::whereDate('date', $today)->where('status', '!=', 'Dibatalkan')->count();
        $upcomingSchedulesCount = Schedule::whereDate('date', '>', $today)->where('status', '!=', 'Dibatalkan')->count();
        $activeDutiesCount = Schedule::whereDate('date', $today)
            ->where('status', 'Sedang Bertugas')
            ->count();

        // 2. Shift breakdown for today
        $shiftCounts = [
            'pagi' => Schedule::whereDate('date', $today)->where('shift', 'Pagi')->where('status', '!=', 'Dibatalkan')->count(),
            'siang' => Schedule::whereDate('date', $today)->where('shift', 'Siang')->where('status', '!=', 'Dibatalkan')->count(),
            'malam' => Schedule::whereDate('date', $today)->where('shift', 'Malam')->where('status', '!=', 'Dibatalkan')->count(),
        ];

        // 3. Jadwal yang sedang berlangsung / aktif hari ini
        $activeDuties = Schedule::with(['shelter', 'officer'])
            ->whereDate('date', $today)
            ->whereIn('status', ['Sedang Bertugas', 'Siaga Shift'])
            ->orderBy('start_time', 'asc')
            ->take(6)
            ->get();

        if ($activeDuties->isEmpty()) {
            $activeDuties = Schedule::with(['shelter', 'officer'])
                ->whereDate('date', $today)
                ->orderBy('start_time', 'asc')
                ->take(6)
                ->get();
        }

        // 4. Primary Schedule Query with Filter & Tabs
        $query = Schedule::with(['shelter', 'officer']);

        $tab = $request->get('tab', 'all');
        if ($tab === 'today') {
            $query->whereDate('date', $today);
        } elseif ($tab === 'active') {
            $query->whereDate('date', $today)->where('status', 'Sedang Bertugas');
        } elseif ($tab === 'upcoming') {
            $query->whereDate('date', '>', $today);
        }

        if ($request->filled('shelter')) {
            $query->where('shelter_id', $request->shelter);
        }

        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('officer', function ($oq) use ($search) {
                    $oq->where('name', 'like', "%{$search}%")
                        ->orWhere('nrp', 'like', "%{$search}%");
                })->orWhereHas('shelter', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                })->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $schedules = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(10)
            ->withQueryString();

        // 5. Chart Data: Distribution of personnel per top shelters
        $topSheltersForChart = Shelter::withCount('officers')
            ->orderByDesc('officers_count')
            ->take(6)
            ->get();

        $chartShelterLabels = $topSheltersForChart->pluck('name')->toArray();
        $chartShelterData = $topSheltersForChart->pluck('officers_count')->toArray();

        // 6. Zone statistics
        $zoneStats = Shelter::selectRaw('zone, count(*) as total, sum(capacity) as total_capacity')
            ->groupBy('zone')
            ->get();

        // 7. Recent activity logs
        $recentLogs = ActivityLog::orderBy('created_at', 'desc')->take(6)->get();

        // 8. Shelters & Officers for dropdowns and filter
        $allShelters = Shelter::orderBy('name')->get();
        $allOfficers = Officer::where('status', '!=', 'Nonaktif')->orderBy('name')->get();

        // 9. Featured shelters for visual preview
        $featuredShelters = Shelter::take(4)->get();

        return view('admin.dashboard', compact(
            'totalShelters',
            'activeSheltersCount',
            'totalCapacity',
            'totalOfficers',
            'activeOfficersCount',
            'standbyOfficersCount',
            'totalSchedules',
            'todaySchedulesCount',
            'upcomingSchedulesCount',
            'activeDutiesCount',
            'shiftCounts',
            'activeDuties',
            'schedules',
            'chartShelterLabels',
            'chartShelterData',
            'zoneStats',
            'recentLogs',
            'allShelters',
            'allOfficers',
            'featuredShelters',
            'today',
            'tab'
        ));
    }

    public function emergencyAlert(Request $request): JsonResponse
    {
        ActivityLog::log(
            'EMERGENCY',
            'Sistem',
            'Peringatan Kritis: Sirene & Sinyal Siaga Darurat diaktifkan oleh '.auth()->user()->name.'. Seluruh regu cadangan dimobilisasi.'
        );

        return response()->json([
            'success' => true,
            'message' => 'Sinyal darurat posko berhasil disiarkan ke seluruh unit regu siaga!',
        ]);
    }
}
