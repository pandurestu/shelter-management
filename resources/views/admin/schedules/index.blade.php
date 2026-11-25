@extends('layouts.app')

@section('title', 'Manajemen Jadwal Plotting')
@section('page-title', 'Jadwal Plotting Penjagaan')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Manajemen Jadwal Plotting</h1>
            <p class="text-xs text-slate-500 mt-1">Plotting shift penjagaan personel posko, deteksi bebas bentrok, dan rotasi waktu jaga 24 jam.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.calendar') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-2 transition-colors">
                <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                <span>Tampilan Kalender</span>
            </a>
            <a href="{{ route('admin.schedules.create') }}" class="px-4 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-2 shadow-sm transition-all hover:scale-[1.02]">
                <span class="material-symbols-outlined text-[18px]">assignment_add</span>
                <span>+ Buat Plotting Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-emerald-900/10 mb-6">
        <form method="GET" action="{{ route('admin.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Cari Penugasan</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Petugas, shelter, catatan..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Filter Shelter</label>
                <select name="shelter_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Shelter</option>
                    @foreach($shelters as $sh)
                        <option value="{{ $sh->id }}" {{ request('shelter_id') == $sh->id ? 'selected' : '' }}>{{ $sh->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Filter Petugas</label>
                <select name="officer_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Petugas</option>
                    @foreach($officers as $off)
                        <option value="{{ $off->id }}" {{ request('officer_id') == $off->id ? 'selected' : '' }}>{{ $off->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Filter Shift</label>
                <select name="shift" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Shift</option>
                    @foreach($shifts as $sf)
                        <option value="{{ $sf }}" {{ request('shift') == $sf ? 'selected' : '' }}>Shift {{ $sf }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Filter Status</label>
                <div class="flex items-center gap-2">
                    <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="all">Semua Status</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                    @if(request()->anyFilled(['search', 'shelter_id', 'officer_id', 'shift', 'status', 'date']))
                        <a href="{{ route('admin.schedules.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600" title="Reset Filter">
                            <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Schedules Table Container -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-emerald-900/10 mb-6">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full min-w-[1050px] text-left text-xs table-auto">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-56 min-w-[200px]">Nama Shelter</th>
                        <th class="py-3.5 px-4 w-60 min-w-[220px]">Nama Petugas Terplot</th>
                        <th class="py-3.5 px-4 w-40 min-w-[150px] whitespace-nowrap">Hari &amp; Tanggal</th>
                        <th class="py-3.5 px-4 w-44 min-w-[160px] whitespace-nowrap">Shift &amp; Jam Jaga</th>
                        <th class="py-3.5 px-4 w-36 min-w-[130px] whitespace-nowrap">Status Penugasan</th>
                        <th class="py-3.5 px-4 min-w-[200px]">Catatan Khusus</th>
                        <th class="py-3.5 px-4 w-28 min-w-[100px] text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($schedules as $sched)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.shelters.show', $sched->shelter_id) }}" class="font-bold text-slate-900 hover:text-emerald-700 flex items-center gap-1.5 whitespace-nowrap">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600 shrink-0"></span>
                                    <span>{{ $sched->shelter?->name ?? 'Posko Induk' }}</span>
                                </a>
                                <span class="text-[11px] text-slate-400 pl-3.5 block whitespace-nowrap">{{ $sched->shelter?->zone ?? '-' }} • Kode: {{ $sched->shelter?->code ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    @if($sched->officer?->avatar_url)
                                        <img src="{{ $sched->officer->avatar_url }}" alt="{{ $sched->officer->name }}" class="w-9 h-9 rounded-full object-cover ring-1 ring-emerald-300 shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-[#14532d] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                            {{ substr($sched->officer?->name ?? 'P', 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <a href="{{ route('admin.officers.show', $sched->officer_id) }}" class="font-bold text-slate-900 hover:text-emerald-700 truncate block">{{ $sched->officer?->name ?? 'Petugas' }}</a>
                                        <span class="text-[11px] text-slate-400 block whitespace-nowrap">NRP: {{ $sched->officer?->nrp ?? '-' }} • {{ $sched->officer?->position ?? 'Petugas' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-bold text-slate-900 block">{{ $sched->day }}, {{ $sched->date->format('d M Y') }}</span>
                                @if($sched->date->isToday())
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase">● Hari Ini</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-lg font-bold text-xs bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    Shift {{ $sched->shift }}
                                </span>
                                <span class="block text-[11px] text-slate-600 mt-1 font-mono font-medium">
                                    {{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }} WIB
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($sched->status === 'Sedang Bertugas')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[11px] border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Sedang Bertugas
                                    </span>
                                @elseif($sched->status === 'Siaga Shift')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 font-bold text-[11px] border border-amber-200">
                                        Siaga Shift
                                    </span>
                                @elseif($sched->status === 'Selesai Shift')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 font-medium text-[11px]">
                                        Selesai Shift
                                    </span>
                                @elseif($sched->status === 'Dibatalkan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 font-medium text-[11px]">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-medium text-[11px]">
                                        {{ $sched->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-slate-600 text-xs block leading-relaxed line-clamp-2" title="{{ $sched->notes }}">
                                    {{ $sched->notes ?: 'Tugas rutin posko' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.schedules.show', $sched) }}" class="p-1.5 rounded-lg hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 transition-colors" title="Detail Plotting">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.schedules.edit', $sched) }}" class="p-1.5 rounded-lg hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 transition-colors" title="Edit Plotting">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.schedules.destroy', $sched) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus jadwal ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg hover:bg-rose-50 text-slate-500 hover:text-rose-600 transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada jadwal plotting yang sesuai kriteria pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection

