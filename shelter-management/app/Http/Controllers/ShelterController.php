<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Shelter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShelterController extends Controller
{
    public function index(Request $request): View
    {
        $query = Shelter::withCount('officers');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('coordinator_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('zone') && $request->zone !== 'all') {
            $query->where('zone', $request->zone);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('risk_level') && $request->risk_level !== 'all') {
            $query->where('risk_level', $request->risk_level);
        }

        $shelters = $query->orderBy('code', 'asc')->paginate(12)->withQueryString();

        $zones = ['Zona Utara', 'Zona Selatan', 'Zona Barat', 'Zona Timur', 'Zona Pusat'];
        $statuses = [
            'siaga_penuh' => 'Siaga Penuh',
            'rutin' => 'Penjagaan Rutin',
            'perawatan' => 'Perawatan & Sterilisasi',
            'darurat' => 'Darurat & Evakuasi',
        ];

        return view('admin.shelters.index', compact('shelters', 'zones', 'statuses'));
    }

    public function create(): View
    {
        $zones = ['Zona Utara', 'Zona Selatan', 'Zona Barat', 'Zona Timur', 'Zona Pusat'];

        return view('admin.shelters.create', compact('zones'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shelters,code',
            'zone' => 'required|string',
            'address' => 'required|string',
            'coordinator_name' => 'required|string|max:255',
            'coordinator_phone' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1',
            'current_occupancy' => 'nullable|integer|min:0',
            'guard_quota' => 'required|integer|min:1',
            'risk_level' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:siaga_penuh,rutin,perawatan,darurat',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama shelter wajib diisi.',
            'code.required' => 'Kode unik shelter wajib diisi.',
            'code.unique' => 'Kode shelter ini sudah digunakan.',
            'address.required' => 'Alamat lokasi shelter wajib diisi.',
            'coordinator_name.required' => 'Nama koordinator penanggung jawab wajib diisi.',
            'capacity.required' => 'Kapasitas daya tampung wajib diisi.',
            'guard_quota.required' => 'Kuota personel penjaga wajib diisi.',
        ]);

        $shelter = Shelter::create($validated);

        ActivityLog::log(
            'CREATE',
            'Shelter',
            'Mendaftarkan unit posko shelter baru: '.$shelter->name.' ('.$shelter->code.')'
        );

        return redirect()->route('admin.shelters.index')->with('success', "Posko Shelter '{$shelter->name}' berhasil didaftarkan ke sistem.");
    }

    public function show(Shelter $shelter): View
    {
        $shelter->load(['officers', 'schedules' => function ($q) {
            $q->with('officer')->orderBy('date', 'desc')->take(10);
        }]);

        return view('admin.shelters.show', compact('shelter'));
    }

    public function edit(Shelter $shelter): View
    {
        $zones = ['Zona Utara', 'Zona Selatan', 'Zona Barat', 'Zona Timur', 'Zona Pusat'];

        return view('admin.shelters.edit', compact('shelter', 'zones'));
    }

    public function update(Request $request, Shelter $shelter): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shelters,code,'.$shelter->id,
            'zone' => 'required|string',
            'address' => 'required|string',
            'coordinator_name' => 'required|string|max:255',
            'coordinator_phone' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1',
            'current_occupancy' => 'nullable|integer|min:0',
            'guard_quota' => 'required|integer|min:1',
            'risk_level' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:siaga_penuh,rutin,perawatan,darurat',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $shelter->update($validated);

        ActivityLog::log(
            'UPDATE',
            'Shelter',
            'Memperbarui data shelter: '.$shelter->name.' ('.$shelter->code.')'
        );

        return redirect()->route('admin.shelters.index')->with('success', "Data Shelter '{$shelter->name}' berhasil diperbarui.");
    }

    public function destroy(Shelter $shelter): RedirectResponse
    {
        $name = $shelter->name;
        $code = $shelter->code;

        $shelter->delete();

        ActivityLog::log(
            'DELETE',
            'Shelter',
            "Menghapus posko shelter {$name} ({$code}) dari database."
        );

        return redirect()->route('admin.shelters.index')->with('success', "Posko Shelter '{$name}' telah berhasil dihapus.");
    }
}
