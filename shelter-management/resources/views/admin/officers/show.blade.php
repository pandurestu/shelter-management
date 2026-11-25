@extends('layouts.app')

@section('title', 'Detail Petugas ' . $officer->name)
@section('page-title', 'Detail Personel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.officers.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">{{ $officer->name }}</h1>
                <p class="text-xs text-slate-500">NRP: {{ $officer->nrp }} • {{ $officer->position }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.officers.edit', $officer) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Edit Profil</span>
            </a>
            <a href="{{ route('admin.schedules.create') }}?officer_id={{ $officer->id }}" class="px-4 py-2 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-[16px]">assignment_add</span>
                <span>+ Plotting Tugas</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Officer Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-900/10 flex flex-col items-center text-center">
            @if($officer->avatar_url)
                <img src="{{ $officer->avatar_url }}" alt="{{ $officer->name }}" class="w-24 h-24 rounded-full object-cover ring-4 ring-emerald-100 mb-3">
            @else
                <div class="w-24 h-24 rounded-full bg-[#14532d] text-white font-bold text-2xl flex items-center justify-center ring-4 ring-emerald-100 mb-3">
                    {{ substr($officer->name, 0, 2) }}
                </div>
            @endif

            <h2 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">{{ $officer->name }}</h2>
            <span class="text-xs font-mono text-slate-500 font-semibold mt-0.5">NRP: {{ $officer->nrp }}</span>
            <span class="mt-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200">
                {{ $officer->position }}
            </span>

            <div class="w-full mt-5 pt-4 border-t border-slate-100 flex flex-col gap-2 text-xs text-left">
                <div class="flex justify-between">
                    <span class="text-slate-500">Status Keaktifan:</span>
                    <span class="font-bold text-emerald-800">{{ $officer->status }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Pos Penempatan:</span>
                    <span class="font-bold text-slate-900">{{ $officer->shelter?->name ?? 'Posko Induk' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Telepon/WA:</span>
                    <span class="font-bold text-slate-900">{{ $officer->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Email:</span>
                    <span class="font-medium text-slate-700">{{ $officer->email ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Details & Assignment History -->
        <div class="md:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-emerald-900/10 flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 font-['Plus_Jakarta_Sans'] mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-700">badge</span>
                    <span>Informasi Domisili &amp; Data Tambahan</span>
                </h3>

                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Alamat Domisili Personel:</span>
                        <p class="text-xs text-slate-700 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200">
                            {{ $officer->address ?? 'Alamat domisili belum diisi oleh petugas.' }}
                        </p>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block mb-2 font-semibold">Riwayat Penugasan &amp; Jadwal Plotting:</span>
                        <div class="divide-y divide-slate-100 max-h-56 overflow-y-auto">
                            @forelse($officer->schedules as $sc)
                                <div class="py-2.5 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900">{{ $sc->shelter?->name ?? 'Posko Induk' }}</span>
                                        <span class="text-[11px] text-slate-500">{{ $sc->day }}, {{ $sc->date->format('d/m/Y') }} • Shift {{ $sc->shift }} ({{ substr($sc->start_time, 0, 5) }}-{{ substr($sc->end_time, 0, 5) }} WIB)</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sc->status === 'Sedang Bertugas' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $sc->status }}
                                    </span>
                                </div>
                            @empty
                                <div class="py-4 text-center text-slate-400">Belum ada riwayat penugasan yang tercatat untuk personel ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Terdaftar sejak: {{ $officer->created_at->translatedFormat('d F Y') }}</span>
                <span>ID Personel: #{{ $officer->id }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

