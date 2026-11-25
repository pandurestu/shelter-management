<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Officer;
use App\Models\Schedule;
use App\Models\Shelter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    private array $daysIndo = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];

    public function index(Request $request): View
    {
        $query = Schedule::with(['shelter', 'officer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('officer', function ($oq) use ($search) {
                    $oq->where('name', 'like', "%{$search}%")
                        ->orWhere('nrp', 'like', "%{$search}%");
                })->orWhereHas('shelter', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                })->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('shelter_id') && $request->shelter_id !== 'all') {
            $query->where('shelter_id', $request->shelter_id);
        }

        if ($request->filled('officer_id') && $request->officer_id !== 'all') {
            $query->where('officer_id', $request->officer_id);
        }

        if ($request->filled('shift') && $request->shift !== 'all') {
            $query->where('shift', $request->shift);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $schedules = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(15)
            ->withQueryString();

        $shelters = Shelter::orderBy('name')->get();
        $officers = Officer::where('status', 'Aktif')->orderBy('name')->get();
        $shifts = ['Pagi', 'Siang', 'Malam'];
        $statuses = ['Sedang Bertugas', 'Siaga Shift', 'Terjadwal', 'Selesai Shift', 'Dibatalkan'];

        return view('admin.schedules.index', compact('schedules', 'shelters', 'officers', 'shifts', 'statuses'));
    }

    public function create(): View
    {
        $shelters = Shelter::orderBy('name')->get();
        $officers = Officer::where('status', '!=', 'Nonaktif')->orderBy('name')->get();
        $shifts = [
            'Pagi' => ['name' => 'Shift 1 - Pagi', 'start' => '07:00', 'end' => '15:00'],
            'Siang' => ['name' => 'Shift 2 - Siang', 'start' => '15:00', 'end' => '23:00'],
            'Malam' => ['name' => 'Shift 3 - Malam', 'start' => '23:00', 'end' => '07:00'],
        ];

        return view('admin.schedules.create', compact('shelters', 'officers', 'shifts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shelter_id' => 'required|exists:shelters,id',
            'officer_id' => 'required|exists:officers,id',
            'date' => 'required|date',
            'shift' => 'required|in:Pagi,Siang,Malam',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:Sedang Bertugas,Siaga Shift,Terjadwal,Selesai Shift,Dibatalkan',
            'notes' => 'nullable|string',
        ], [
            'shelter_id.required' => 'Shelter penugasan wajib dipilih.',
            'officer_id.required' => 'Petugas yang diplot wajib dipilih.',
            'date.required' => 'Tanggal penjagaan wajib diisi.',
            'shift.required' => 'Shift jaga wajib dipilih.',
            'start_time.required' => 'Jam mulai tugas wajib diisi.',
            'end_time.required' => 'Jam selesai tugas wajib diisi.',
        ]);

        // CRITICAL CONFLICT DETECTION: Check if officer already has a schedule on same date and shift or overlapping time
        $conflict = Schedule::where('officer_id', $validated['officer_id'])
            ->whereDate('date', $validated['date'])
            ->where('status', '!=', 'Dibatalkan')
            ->where(function ($q) use ($validated) {
                $q->where('shift', $validated['shift'])
                    ->orWhere(function ($tq) use ($validated) {
                        $tq->where('start_time', '<', $validated['end_time'])
                            ->where('end_time', '>', $validated['start_time']);
                    });
            })
            ->with(['shelter', 'officer'])
            ->first();

        if ($conflict) {
            $officerName = $conflict->officer->name;
            $shelterName = $conflict->shelter->name;
            $conflictDate = Carbon::parse($validated['date'])->translatedFormat('d F Y');

            return back()->withInput()->withErrors([
                'officer_id' => "BENTROK JADWAL TERDETEKSI! Petugas {$officerName} sudah memiliki jadwal aktif pada {$conflictDate} (Shift {$conflict->shift}, {$conflict->start_time} - {$conflict->end_time}) di {$shelterName}. Satu personel tidak boleh memiliki dua jadwal di waktu yang sama.",
            ]);
        }

        // Automatic day calculation
        $carbonDate = Carbon::parse($validated['date']);
        $dayEnglish = $carbonDate->format('l');
        $validated['day'] = $this->daysIndo[$dayEnglish] ?? 'Senin';
        $validated['created_by'] = auth()->id();

        $schedule = Schedule::create($validated);

        ActivityLog::log(
            'CREATE',
            'Jadwal',
            "Membuat plotting jadwal: {$schedule->officer->name} di {$schedule->shelter->name} (Shift {$schedule->shift}, Tgl {$schedule->date->format('d/m/Y')})"
        );

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal plotting berhasil disimpan dan diverifikasi bebas bentrok.');
    }

    public function show(Schedule $schedule): View
    {
        $schedule->load(['shelter', 'officer', 'creator']);

        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule): View
    {
        $shelters = Shelter::orderBy('name')->get();
        $officers = Officer::where('status', '!=', 'Nonaktif')->orderBy('name')->get();
        $shifts = [
            'Pagi' => ['name' => 'Shift 1 - Pagi', 'start' => '07:00', 'end' => '15:00'],
            'Siang' => ['name' => 'Shift 2 - Siang', 'start' => '15:00', 'end' => '23:00'],
            'Malam' => ['name' => 'Shift 3 - Malam', 'start' => '23:00', 'end' => '07:00'],
        ];

        return view('admin.schedules.edit', compact('schedule', 'shelters', 'officers', 'shifts'));
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'shelter_id' => 'required|exists:shelters,id',
            'officer_id' => 'required|exists:officers,id',
            'date' => 'required|date',
            'shift' => 'required|in:Pagi,Siang,Malam',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:Sedang Bertugas,Siaga Shift,Terjadwal,Selesai Shift,Dibatalkan',
            'notes' => 'nullable|string',
        ]);

        // Conflict check excluding current schedule
        $conflict = Schedule::where('officer_id', $validated['officer_id'])
            ->whereDate('date', $validated['date'])
            ->where('id', '!=', $schedule->id)
            ->where('status', '!=', 'Dibatalkan')
            ->where(function ($q) use ($validated) {
                $q->where('shift', $validated['shift'])
                    ->orWhere(function ($tq) use ($validated) {
                        $tq->where('start_time', '<', $validated['end_time'])
                            ->where('end_time', '>', $validated['start_time']);
                    });
            })
            ->with(['shelter', 'officer'])
            ->first();

        if ($conflict) {
            $officerName = $conflict->officer->name;
            $shelterName = $conflict->shelter->name;
            $conflictDate = Carbon::parse($validated['date'])->translatedFormat('d F Y');

            return back()->withInput()->withErrors([
                'officer_id' => "BENTROK JADWAL TERDETEKSI! Petugas {$officerName} sudah memiliki jadwal lain pada {$conflictDate} (Shift {$conflict->shift}) di {$shelterName}.",
            ]);
        }

        // Automatic day calculation
        $carbonDate = Carbon::parse($validated['date']);
        $dayEnglish = $carbonDate->format('l');
        $validated['day'] = $this->daysIndo[$dayEnglish] ?? 'Senin';

        $schedule->update($validated);

        ActivityLog::log(
            'UPDATE',
            'Jadwal',
            "Memperbarui plotting jadwal ID #{$schedule->id}: {$schedule->officer->name} di {$schedule->shelter->name} (Shift {$schedule->shift})"
        );

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal plotting berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $info = "Jadwal {$schedule->officer->name} di {$schedule->shelter->name} tanggal {$schedule->date->format('d/m/Y')}";
        $schedule->delete();

        ActivityLog::log(
            'DELETE',
            'Jadwal',
            "Menghapus plotting jadwal: {$info}"
        );

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal plotting telah berhasil dihapus.');
    }

    /**
     * AJAX Conflict Checking API endpoint for simulation and live form validation.
     */
    public function checkConflict(Request $request): JsonResponse
    {
        $officerId = $request->officer_id;
        $date = $request->date;
        $shift = $request->shift;
        $excludeId = $request->exclude_id;

        if (! $officerId || ! $date || ! $shift) {
            return response()->json([
                'valid' => true,
                'has_conflict' => false,
                'message' => 'Lengkapi data untuk memeriksa konflik.',
            ]);
        }

        $query = Schedule::where('officer_id', $officerId)
            ->whereDate('date', $date)
            ->where('shift', $shift)
            ->where('status', '!=', 'Dibatalkan');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $conflict = $query->with(['shelter', 'officer'])->first();

        if ($conflict) {
            return response()->json([
                'valid' => false,
                'has_conflict' => true,
                'message' => "BENTROK TERDETEKSI! Petugas {$conflict->officer->name} sudah ditugaskan pada Shift {$conflict->shift} di {$conflict->shelter->name} ({$conflict->start_time} - {$conflict->end_time} WIB).",
                'conflict_schedule' => [
                    'shelter' => $conflict->shelter->name,
                    'shift' => $conflict->shift,
                    'time' => "{$conflict->start_time} - {$conflict->end_time}",
                ],
            ]);
        }

        return response()->json([
            'valid' => true,
            'has_conflict' => false,
            'message' => 'Jadwal Valid & Bebas Konflik. Personel tidak memiliki penugasan lain dalam jendela waktu ini.',
        ]);
    }

    /**
     * Quick status update endpoint for dashboard & interactive table.
     */
    public function updateStatus(Request $request, Schedule $schedule): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:Sedang Bertugas,Siaga Shift,Terjadwal,Selesai Shift,Dibatalkan',
        ]);

        $oldStatus = $schedule->status;
        $schedule->update(['status' => $validated['status']]);

        ActivityLog::log(
            'UPDATE_STATUS',
            'Jadwal',
            "Status jadwal {$schedule->officer?->name} di {$schedule->shelter?->name} diperbarui dari {$oldStatus} ke {$schedule->status}."
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status jadwal berhasil diubah menjadi {$schedule->status}",
                'new_status' => $schedule->status,
            ]);
        }

        return back()->with('success', "Status jadwal berhasil diubah menjadi {$schedule->status}");
    }
}
