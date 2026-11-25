<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Shelter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today();

        // Stats
        $totalShelters = Shelter::count();
        $totalOfficers = Officer::count();
        $totalActiveSchedules = Schedule::where('status', '!=', 'Dibatalkan')->count();
        $todaySchedulesCount = Schedule::whereDate('date', $today)->count();

        // Shelters for grid
        $shelters = Shelter::withCount('officers')
            ->orderBy('id', 'asc')
            ->get();

        // Schedules for live table
        $schedules = Schedule::with(['shelter', 'officer'])
            ->whereDate('date', '>=', $today->copy()->subDays(1))
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->take(15)
            ->get();

        // Settings
        $settings = [
            'site_name' => Setting::get('site_name', 'SHELTER MANAGEMENT SYSTEM'),
            'site_tagline' => Setting::get('site_tagline', 'PENJAGAAN SATWA & BENCANA TERPADU'),
            'hotline_toll_free' => Setting::get('hotline_toll_free', '1500 - 8989'),
            'hotline_office' => Setting::get('hotline_office', '+62 21 555-8910'),
            'emergency_radio' => Setting::get('emergency_radio', '144.520 MHz (Kanal Darurat)'),
            'coordination_email' => Setting::get('coordination_email', 'posko@shelter-system.go.id'),
            'coordination_unit' => Setting::get('coordination_unit', 'Satgas Penjagaan Wilayah'),
            'command_center_address' => Setting::get('command_center_address', 'Posko Induk Pusat Komando Wilayah'),
            'operational_status' => Setting::get('operational_status', 'Level 1 Siaga Operasional'),
        ];

        return view('home', compact(
            'totalShelters',
            'totalOfficers',
            'totalActiveSchedules',
            'todaySchedulesCount',
            'shelters',
            'schedules',
            'settings',
            'today'
        ));
    }
}
