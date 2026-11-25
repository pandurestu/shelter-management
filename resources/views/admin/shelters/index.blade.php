@extends('layouts.app')

@section('title', 'Manajemen Data Shelter')
@section('page-title', 'Data Master Shelter')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Manajemen Data Shelter</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data posko shelter, lokasi perimeter, koordinator lapangan, dan daya tampung.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.shelters.create') }}" class="px-4 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-2 shadow-sm transition-all hover:scale-[1.02]">
                <span class="material-symbols-outlined text-[18px]">add_business</span>
                <span>+ Tambah Pos Shelter Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-emerald-900/10 mb-6">
        <form method="GET" action="{{ route('admin.shelters.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pencarian</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kode, lokasi, koordinator..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Zona Wilayah</label>
                <select name="zone" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Zona Wilayah</option>
                    @foreach($zones as $z)
                        <option value="{{ $z }}" {{ request('zone') == $z ? 'selected' : '' }}>{{ $z }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Kesiapan</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Status</option>
                    @foreach($statuses as $k => $v)
                        <option value="{{ $k }}" {{ request('status') == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tingkat Risiko</label>
                <div class="flex items-center gap-2">
                    <select name="risk_level" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="all">Semua Risiko</option>
                        <option value="rendah" {{ request('risk_level') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ request('risk_level') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ request('risk_level') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                    @if(request()->anyFilled(['search', 'zone', 'status', 'risk_level']))
                        <a href="{{ route('admin.shelters.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600" title="Reset Filter">
                            <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Shelters Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
        @forelse($shelters as $sh)
            @php
                $capPercent = min(100, round(($sh->current_occupancy / max(1, $sh->capacity)) * 100));
                $riskClasses = [
                    'tinggi' => 'bg-rose-50 text-rose-700 border-rose-200',
                    'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'rendah' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                ];
                $riskBadge = $riskClasses[$sh->risk_level] ?? 'bg-slate-50 text-slate-700 border-slate-200';
            @endphp
            <div class="flex flex-col justify-between rounded-2xl bg-white border border-emerald-900/10 shadow-sm hover:shadow-md transition-all group overflow-hidden h-full">
                <div class="relative overflow-hidden bg-slate-100">
                    @if($sh->image_url)
                        <img alt="{{ $sh->name }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $sh->image_url }}"/>
                    @else
                        <div class="w-full h-44 bg-gradient-to-br from-[#0a2316] to-[#14532d] flex items-center justify-center text-emerald-300">
                            <span class="material-symbols-outlined text-[40px]">domain</span>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 rounded-lg bg-slate-900/80 backdrop-blur-md text-white font-mono font-bold text-[11px] shadow-sm tracking-wider">
                            {{ $sh->code }}
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 rounded-full bg-white/95 backdrop-blur-md text-emerald-800 font-bold text-[11px] shadow-sm border border-emerald-100 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                            {{ ucfirst(str_replace('_', ' ', $sh->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-4 flex flex-col justify-between flex-1">
                    <div>
                        <div class="flex items-center justify-between text-[11px] font-bold mb-1.5">
                            <span class="text-emerald-800 uppercase tracking-wider text-[10px]">{{ $sh->zone }}</span>
                            <span class="px-2 py-0.5 rounded-md border text-[10px] font-semibold {{ $riskBadge }}">
                                Risiko: {{ ucfirst($sh->risk_level) }}
                            </span>
                        </div>
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-emerald-700 transition-colors font-['Plus_Jakarta_Sans'] leading-snug">{{ $sh->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1 flex items-start gap-1 line-clamp-2">
                            <span class="material-symbols-outlined text-[15px] text-emerald-600 shrink-0 mt-0.5">location_on</span>
                            <span>{{ $sh->address }}</span>
                        </p>
                        @if($sh->description)
                            <p class="text-[11px] text-slate-400 mt-1.5 italic line-clamp-1">"{{ $sh->description }}"</p>
                        @endif

                        <div class="mt-3 pt-3 border-t border-slate-100 flex flex-col gap-1.5 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-[11px]">Koordinator:</span>
                                <span class="text-slate-900 font-semibold truncate max-w-[150px] text-right">{{ $sh->coordinator_name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-[11px]">Personel Pos:</span>
                                <span class="text-emerald-700 font-bold">{{ $sh->officers_count }} Petugas</span>
                            </div>
                            <div class="flex flex-col gap-1 mt-0.5">
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-slate-500">Kapasitas:</span>
                                    <span class="text-slate-900 font-semibold">{{ $sh->current_occupancy }} / {{ $sh->capacity }} Jiwa</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-full rounded-full {{ $capPercent >= 90 ? 'bg-rose-500' : ($capPercent >= 70 ? 'bg-amber-500' : 'bg-emerald-600') }}" style="width: {{ $capPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-1.5">
                        <a href="{{ route('admin.shelters.show', $sh) }}" class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-[#14532d] text-slate-700 hover:text-white text-xs font-bold text-center transition-all shadow-xs">
                            Detail
                        </a>
                        <a href="{{ route('admin.shelters.edit', $sh) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form action="{{ route('admin.shelters.destroy', $sh) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus shelter {{ $sh->name }}? Semua data plotting yang terkait juga akan dihapus.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors" title="Hapus">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">domain_disabled</span>
                <p class="text-sm">Tidak ada shelter yang sesuai dengan filter pencarian.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $shelters->links() }}
    </div>
</div>
@endsection

