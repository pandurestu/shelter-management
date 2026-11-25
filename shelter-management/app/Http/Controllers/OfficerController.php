<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Officer;
use App\Models\Shelter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfficerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Officer::with('shelter');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nrp', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('shelter_id') && $request->shelter_id !== 'all') {
            $query->where('shelter_id', $request->shelter_id);
        }

        if ($request->filled('position') && $request->position !== 'all') {
            $query->where('position', $request->position);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $officers = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        $shelters = Shelter::orderBy('name')->get();
        $positions = [
            'Komandan Regu',
            'Ranger Sektor',
            'Medis Satwa',
            'Anggota Patroli',
            'Security Pos',
        ];
        $statuses = ['Aktif', 'Siaga', 'Cuti', 'Nonaktif'];

        return view('admin.officers.index', compact('officers', 'shelters', 'positions', 'statuses'));
    }

    public function create(): View
    {
        $shelters = Shelter::orderBy('name')->get();
        $positions = [
            'Komandan Regu',
            'Ranger Sektor',
            'Medis Satwa',
            'Anggota Patroli',
            'Security Pos',
        ];

        return view('admin.officers.create', compact('shelters', 'positions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nrp' => 'required|string|max:50|unique:officers,nrp',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'position' => 'required|string',
            'shelter_id' => 'nullable|exists:shelters,id',
            'status' => 'required|in:Aktif,Siaga,Cuti,Nonaktif',
            'avatar_url' => 'nullable|url',
        ], [
            'nrp.required' => 'Nomor Identitas Personel (NRP/NIP) wajib diisi.',
            'nrp.unique' => 'NRP ini telah terdaftar untuk petugas lain.',
            'name.required' => 'Nama lengkap petugas wajib diisi.',
            'position.required' => 'Jabatan operasional wajib dipilih.',
        ]);

        $officer = Officer::create($validated);

        ActivityLog::log(
            'CREATE',
            'Petugas',
            'Mendaftarkan personel petugas baru: '.$officer->name.' (NRP: '.$officer->nrp.')'
        );

        return redirect()->route('admin.officers.index')->with('success', "Petugas '{$officer->name}' berhasil ditambahkan ke database.");
    }

    public function show(Officer $officer): View
    {
        $officer->load(['shelter', 'schedules' => function ($q) {
            $q->with('shelter')->orderBy('date', 'desc')->take(10);
        }]);

        return view('admin.officers.show', compact('officer'));
    }

    public function edit(Officer $officer): View
    {
        $shelters = Shelter::orderBy('name')->get();
        $positions = [
            'Komandan Regu',
            'Ranger Sektor',
            'Medis Satwa',
            'Anggota Patroli',
            'Security Pos',
        ];

        return view('admin.officers.edit', compact('officer', 'shelters', 'positions'));
    }

    public function update(Request $request, Officer $officer): RedirectResponse
    {
        $validated = $request->validate([
            'nrp' => 'required|string|max:50|unique:officers,nrp,'.$officer->id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'position' => 'required|string',
            'shelter_id' => 'nullable|exists:shelters,id',
            'status' => 'required|in:Aktif,Siaga,Cuti,Nonaktif',
            'avatar_url' => 'nullable|url',
        ]);

        $officer->update($validated);

        ActivityLog::log(
            'UPDATE',
            'Petugas',
            'Memperbarui data personel: '.$officer->name.' (NRP: '.$officer->nrp.')'
        );

        return redirect()->route('admin.officers.index')->with('success', "Data Petugas '{$officer->name}' berhasil diperbarui.");
    }

    public function destroy(Officer $officer): RedirectResponse
    {
        $name = $officer->name;
        $nrp = $officer->nrp;

        $officer->delete();

        ActivityLog::log(
            'DELETE',
            'Petugas',
            "Menghapus data personel {$name} (NRP: {$nrp}) dari sistem."
        );

        return redirect()->route('admin.officers.index')->with('success', "Personel '{$name}' telah dihapus dari sistem.");
    }
}
