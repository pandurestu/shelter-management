@extends('layouts.app')

@section('title', 'Manajemen Data Petugas')
@section('page-title', 'Data Master Personel')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Manajemen Data Petugas</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar seluruh personel satgas, komandan regu, ranger, medis satwa, dan anggota patroli.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.officers.create') }}" class="px-4 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-2 shadow-sm transition-all hover:scale-[1.02]">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                <span>+ Daftarkan Petugas Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-emerald-900/10 mb-6">
        <form method="GET" action="{{ route('admin.officers.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pencarian Petugas</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NRP, telepon, jabatan..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pos Shelter Penempatan</label>
                <select name="shelter_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Shelter</option>
                    @foreach($shelters as $sh)
                        <option value="{{ $sh->id }}" {{ request('shelter_id') == $sh->id ? 'selected' : '' }}>{{ $sh->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan Operasional</label>
                <select name="position" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Jabatan</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Keaktifan</label>
                <div class="flex items-center gap-2">
                    <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="all">Semua Status</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    @if(request()->anyFilled(['search', 'shelter_id', 'position', 'status']))
                        <a href="{{ route('admin.officers.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600" title="Reset Filter">
                            <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Officers Table / Cards Container -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-emerald-900/10 mb-6">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full min-w-[950px] text-left text-xs table-auto">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-60 min-w-[220px]">Petugas &amp; Foto</th>
                        <th class="py-3.5 px-4 w-36 min-w-[130px] whitespace-nowrap">Nomor NRP / NIP</th>
                        <th class="py-3.5 px-4 w-44 min-w-[150px] whitespace-nowrap">Jabatan</th>
                        <th class="py-3.5 px-4 w-48 min-w-[180px] whitespace-nowrap">Pos Penempatan</th>
                        <th class="py-3.5 px-4 w-36 min-w-[130px] whitespace-nowrap">Kontak Telepon</th>
                        <th class="py-3.5 px-4 w-36 min-w-[130px] whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 w-28 min-w-[100px] text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($officers as $off)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    @if($off->avatar_url)
                                        <img src="{{ $off->avatar_url }}" alt="{{ $off->name }}" class="w-9 h-9 rounded-full object-cover shrink-0 ring-1 ring-emerald-300">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-[#14532d] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                                            {{ substr($off->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <a href="{{ route('admin.officers.show', $off) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition-colors truncate block">{{ $off->name }}</a>
                                        <span class="text-[11px] text-slate-400 truncate block">{{ $off->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-slate-700 whitespace-nowrap">
                                {{ $off->nrp }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 font-semibold border border-emerald-200">
                                    {{ $off->position }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($off->shelter)
                                    <a href="{{ route('admin.shelters.show', $off->shelter) }}" class="font-semibold text-slate-900 hover:text-emerald-700 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-emerald-600 shrink-0"></span>
                                        <span>{{ $off->shelter->name }}</span>
                                    </a>
                                    <span class="text-[10px] text-slate-400 pl-3.5 block">{{ $off->shelter->zone }}</span>
                                @else
                                    <span class="text-slate-400 italic">Posko Induk / Siaga Umum</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-slate-700 font-mono">{{ $off->phone ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($off->status === 'Aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Aktif
                                    </span>
                                @elseif($off->status === 'Siaga')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 font-bold text-[11px] border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Siaga Cadangan
                                    </span>
                                @elseif($off->status === 'Cuti')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold text-[11px]">
                                        Cuti Dinas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 font-medium text-[11px]">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.officers.show', $off) }}" class="p-1 rounded-lg hover:bg-emerald-50 text-slate-500 hover:text-emerald-700" title="Detail Personel">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.officers.edit', $off) }}" class="p-1 rounded-lg hover:bg-emerald-50 text-slate-500 hover:text-emerald-700" title="Edit Personel">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.officers.destroy', $off) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data petugas {{ $off->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 rounded-lg hover:bg-rose-50 text-slate-500 hover:text-rose-600" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada personel yang sesuai kriteria pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $officers->links() }}
        </div>
    </div>
</div>
@endsection

