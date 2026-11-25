@extends('layouts.app')

@section('title', 'Detail Plotting Jadwal')
@section('page-title', 'Detail Plotting')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.schedules.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Detail Plotting Penugasan</h1>
                <p class="text-xs text-slate-500">Rincian giliran jaga posko, personel bertugas, dan status verifikasi.</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Edit Plotting</span>
            </a>
            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold flex items-center gap-1.5 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
        <!-- Top Status Banner -->
        <div class="p-4 rounded-xl mb-6 flex items-center justify-between {{ $schedule->status === 'Sedang Bertugas' ? 'bg-emerald-50 border border-emerald-200' : 'bg-slate-50 border border-slate-200' }}">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full {{ $schedule->status === 'Sedang Bertugas' ? 'bg-emerald-600 animate-pulse' : 'bg-slate-400' }}"></span>
                <div>
                    <span class="text-xs text-slate-500 block">Status Operasional Penugasan:</span>
                    <span class="text-sm font-bold {{ $schedule->status === 'Sedang Bertugas' ? 'text-emerald-800' : 'text-slate-800' }}">
                        {{ $schedule->status }}
                    </span>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $schedule->shift === 'Pagi' ? 'bg-emerald-100 text-emerald-800' : ($schedule->shift === 'Siang' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                Shift {{ $schedule->shift }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <!-- Shelter Details -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-2.5">
                <div class="flex items-center justify-between border-b border-slate-200/70 pb-2">
                    <span class="font-bold text-slate-800 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-emerald-700 text-[18px]">corporate_fare</span>
                        <span>Posko Shelter</span>
                    </span>
                    <a href="{{ route('admin.shelters.show', $schedule->shelter_id) }}" class="text-emerald-700 font-bold hover:underline">Buka Pos →</a>
                </div>
                <div>
                    <span class="text-slate-400 block">Nama Posko:</span>
                    <span class="text-sm font-bold text-slate-900">{{ $schedule->shelter?->name ?? 'Posko Induk' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Zona &amp; Kode:</span>
                    <span class="text-slate-800 font-medium">{{ $schedule->shelter?->zone }} (Kode: {{ $schedule->shelter?->code }})</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Lokasi:</span>
                    <span class="text-slate-700">{{ $schedule->shelter?->address }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Perwira Koordinator:</span>
                    <span class="text-slate-800 font-semibold">{{ $schedule->shelter?->coordinator_name ?? '-' }}</span>
                </div>
            </div>

            <!-- Officer Details -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-2.5">
                <div class="flex items-center justify-between border-b border-slate-200/70 pb-2">
                    <span class="font-bold text-slate-800 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-emerald-700 text-[18px]">badge</span>
                        <span>Personel Bertugas</span>
                    </span>
                    <a href="{{ route('admin.officers.show', $schedule->officer_id) }}" class="text-emerald-700 font-bold hover:underline">Buka Profil →</a>
                </div>
                <div>
                    <span class="text-slate-400 block">Nama Petugas:</span>
                    <span class="text-sm font-bold text-slate-900">{{ $schedule->officer?->name ?? 'Petugas' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Nomor Identitas (NRP):</span>
                    <span class="text-slate-800 font-mono font-bold">{{ $schedule->officer?->nrp ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Jabatan Operasional:</span>
                    <span class="text-slate-800 font-medium">{{ $schedule->officer?->position ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Kontak Telepon:</span>
                    <span class="text-slate-800">{{ $schedule->officer?->phone ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Schedule Waktu Grid -->
        <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div>
                <span class="text-slate-500 block">Hari &amp; Tanggal:</span>
                <span class="text-sm font-bold text-slate-900">{{ $schedule->day }}, {{ $schedule->date->format('d F Y') }}</span>
            </div>
            <div>
                <span class="text-slate-500 block">Jam Pelaksanaan:</span>
                <span class="text-sm font-bold text-slate-900 font-mono">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</span>
            </div>
            <div>
                <span class="text-slate-500 block">Durasi Sesi Jaga:</span>
                <span class="text-sm font-bold text-emerald-800">8 Jam Rotasi Standar</span>
            </div>
        </div>

        <!-- Notes -->
        <div class="mt-6">
            <span class="text-xs font-bold text-slate-700 block mb-1">Catatan Operasional &amp; Tugas Khusus:</span>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 leading-relaxed">
                {{ $schedule->notes ?? 'Tidak ada catatan operasional khusus. Petugas menjalankan patroli standar posko.' }}
            </div>
        </div>

        <!-- Metadata -->
        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
            <span>Diterbitkan oleh: {{ $schedule->creator?->name ?? 'Sistem Roster' }}</span>
            <span>Dibuat: {{ $schedule->created_at->translatedFormat('d/m/Y H:i') }} WIB</span>
        </div>
    </div>
</div>
@endsection

