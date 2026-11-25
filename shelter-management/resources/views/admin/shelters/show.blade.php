@extends('layouts.app')

@section('title', 'Detail Shelter ' . $shelter->name)
@section('page-title', 'Detail Posko')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.shelters.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">{{ $shelter->name }} ({{ $shelter->code }})</h1>
                <p class="text-xs text-slate-500">{{ $shelter->zone }} • Terdaftar pada live system</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.shelters.edit', $shelter) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Edit Data</span>
            </a>
            <a href="{{ route('admin.schedules.create') }}?shelter_id={{ $shelter->id }}" class="px-4 py-2 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-[16px]">assignment_add</span>
                <span>+ Plotting ke Pos Ini</span>
            </a>
        </div>
    </div>

    <!-- Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Visual & Status -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-emerald-900/10">
            @if($shelter->image_url)
                <img src="{{ $shelter->image_url }}" alt="{{ $shelter->name }}" class="w-full h-52 object-cover">
            @else
                <div class="w-full h-52 bg-gradient-to-br from-[#0a2316] to-[#14532d] flex items-center justify-center text-emerald-300">
                    <span class="material-symbols-outlined text-[64px]">domain</span>
                </div>
            @endif

            <div class="p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Status Operasional:</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                        {{ ucfirst(str_replace('_', ' ', $shelter->status)) }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Tingkat Risiko:</span>
                    <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $shelter->risk_level === 'tinggi' ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800' }}">
                        {{ ucfirst($shelter->risk_level) }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Kapasitas Maksimal:</span>
                    <span class="text-xs font-bold text-slate-900">{{ $shelter->capacity }} Jiwa</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Jumlah Terisi:</span>
                    <span class="text-xs font-bold text-slate-900">{{ $shelter->current_occupancy }} Jiwa</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Kuota Personel / Shift:</span>
                    <span class="text-xs font-bold text-emerald-700">{{ $shelter->guard_quota }} Personel</span>
                </div>
            </div>
        </div>

        <!-- Information & Location -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-emerald-900/10 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans'] mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-700">info</span>
                    <span>Informasi Detail Posko</span>
                </h3>

                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Alamat Lokasi Perimeter:</span>
                        <p class="text-sm font-semibold text-slate-800 flex items-start gap-1">
                            <span class="material-symbols-outlined text-[18px] text-emerald-600 shrink-0">location_on</span>
                            {{ $shelter->address }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-slate-400 block mb-0.5">Perwira Koordinator Lapangan:</span>
                            <span class="text-sm font-bold text-slate-900">{{ $shelter->coordinator_name }}</span>
                            @if($shelter->coordinator_phone)
                                <span class="block text-slate-500 mt-0.5">Telp/WA: {{ $shelter->coordinator_phone }}</span>
                            @endif
                        </div>

                        <div>
                            <span class="text-slate-400 block mb-0.5">Zona Koordinasi Wilayah:</span>
                            <span class="text-sm font-bold text-emerald-800">{{ $shelter->zone }}</span>
                            <span class="block text-slate-500 mt-0.5">Kode Unik: {{ $shelter->code }}</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block mb-0.5">Deskripsi Fasilitas &amp; Catatan Khusus:</span>
                        <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200">
                            {{ $shelter->description ?? 'Tidak ada catatan fasilitas khusus untuk posko ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Didaftarkan: {{ $shelter->created_at->translatedFormat('d F Y - H:i') }} WIB</span>
                <span>Terakhir diupdate: {{ $shelter->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>

    <!-- Assigned Officers & Recent Schedules Tabs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Assigned Officers List -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-900/10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 font-['Plus_Jakarta_Sans'] flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-700">groups</span>
                    <span>Petugas Penempatan di Pos Ini ({{ $shelter->officers->count() }})</span>
                </h3>
                <a href="{{ route('admin.officers.create') }}?shelter_id={{ $shelter->id }}" class="text-xs text-emerald-700 font-bold hover:underline">+ Personel</a>
            </div>

            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                @forelse($shelter->officers as $off)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2.5">
                            @if($off->avatar_url)
                                <img src="{{ $off->avatar_url }}" alt="{{ $off->name }}" class="w-8 h-8 rounded-full object-cover ring-1 ring-emerald-300">
                            @else
                                <div class="w-8 h-8 rounded-full bg-[#14532d] text-white font-bold flex items-center justify-center text-xs">
                                    {{ substr($off->name, 0, 2) }}
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <a href="{{ route('admin.officers.show', $off) }}" class="font-bold text-slate-900 hover:text-emerald-700">{{ $off->name }}</a>
                                <span class="text-[10px] text-slate-400">NRP: {{ $off->nrp }} • {{ $off->position }}</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $off->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $off->status }}
                        </span>
                    </div>
                @empty
                    <div class="py-6 text-center text-slate-400 text-xs">Belum ada personel yang ditempatkan secara permanen di shelter ini.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Schedules at this Shelter -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-900/10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 font-['Plus_Jakarta_Sans'] flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-700">calendar_month</span>
                    <span>Jadwal Plotting Terkini</span>
                </h3>
                <a href="{{ route('admin.schedules.index', ['shelter_id' => $shelter->id]) }}" class="text-xs text-emerald-700 font-bold hover:underline">Semua Jadwal Pos →</a>
            </div>

            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                @forelse($shelter->schedules as $sc)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900">{{ $sc->officer?->name ?? 'Petugas' }}</span>
                            <span class="text-[10px] text-slate-500">{{ $sc->day }}, {{ $sc->date->format('d/m/Y') }} • Shift {{ $sc->shift }} ({{ substr($sc->start_time, 0, 5) }}-{{ substr($sc->end_time, 0, 5) }} WIB)</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sc->status === 'Sedang Bertugas' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $sc->status }}
                        </span>
                    </div>
                @empty
                    <div class="py-6 text-center text-slate-400 text-xs">Belum ada jadwal plotting yang tercatat untuk pos ini.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

