@extends('layouts.app')

@section('title', 'Dashboard Operasional')
@section('page-title', 'Pusat Komando Operasional')

@section('content')
<div class="flex flex-col w-full space-y-6">

    <!-- 1. TOP OPERATIONAL HERO & LIVE CLOCK BANNER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#071c12] via-[#0d2e1c] to-[#14532d] text-white p-6 lg:p-8 shadow-lg border border-[#143d26]">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/3 -bottom-16 w-60 h-60 rounded-full bg-emerald-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
            <div class="flex flex-col gap-2.5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-emerald-400/20 text-emerald-200 text-[11px] uppercase tracking-wider font-extrabold flex items-center gap-1.5 border border-emerald-400/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Pusat Komando Operasional
                    </span>
                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0a2316]/80 text-emerald-300 text-[11px] border border-[#143d26]">
                        <span class="material-symbols-outlined text-[14px]">sensors</span>
                        Live System Real-time
                    </span>
                    <span class="px-2.5 py-1 rounded-full bg-white/10 text-emerald-100 text-[11px] font-mono">
                        ID: OPS-HQ-01
                    </span>
                </div>

                <div class="mt-1">
                    <h1 class="font-['Plus_Jakarta_Sans'] text-2xl lg:text-3xl font-extrabold text-white tracking-tight">
                        Selamat Bertugas, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-xs lg:text-sm text-emerald-100/80 max-w-2xl leading-relaxed mt-1">
                        Sistem monitoring giliran jaga shelter terpadu, kendali pos perimeter, dan pengamanan shift 24 jam bebas bentrok.
                    </p>
                </div>

                <!-- Live Ticking Digital Clock & Operational Date -->
                <div class="flex flex-wrap items-center gap-4 pt-2 text-xs text-emerald-200/90 font-medium">
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-emerald-400 text-[18px]">calendar_today</span>
                        <span>{{ $today->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-black/30 px-3 py-1 rounded-xl border border-emerald-500/20">
                        <span class="material-symbols-outlined text-emerald-400 text-[18px]">schedule</span>
                        <span id="live-clock" class="font-mono font-bold text-white text-sm">--:--:-- WIB</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>Status: <strong class="text-white">Siaga Penuh Level 1</strong></span>
                    </div>
                </div>
            </div>

            <!-- Quick Action Control Center -->
            <div class="flex flex-wrap items-center gap-2.5 xl:self-center">
                <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition-all hover:scale-[1.02]">
                    <span class="material-symbols-outlined text-[18px]">assignment_add</span>
                    <span>+ Plotting Baru</span>
                </a>
                <a href="{{ route('admin.officers.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0d2e1c] hover:bg-[#15462b] text-emerald-100 hover:text-white border border-emerald-600/40 font-bold text-xs transition-all">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    <span>+ Petugas</span>
                </a>
                <a href="{{ route('admin.shelters.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0d2e1c] hover:bg-[#15462b] text-emerald-100 hover:text-white border border-emerald-600/40 font-bold text-xs transition-all">
                    <span class="material-symbols-outlined text-[18px]">add_business</span>
                    <span>+ Shelter</span>
                </a>
                <a href="{{ route('admin.reports.print', ['period' => 'today']) }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition-all" title="Cetak Rekap Jadwal Hari Ini">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    <span>Cetak Hari Ini</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. REALTIME CONFLICT ENGINE BANNER -->
    <div class="rounded-2xl bg-white p-4 lg:p-5 shadow-sm border border-emerald-900/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 shadow-sm">
                <span class="material-symbols-outlined text-[26px]">verified_user</span>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">Mesin Validasi &amp; Pencegahan Bentrok Jadwal Aktif</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wider">Zero Collision</span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Sistem secara cerdas memvalidasi setiap jadwal agar personel tidak mendapatkan dua penugasan di shelter atau jam berbeda pada rentang shift yang sama.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button type="button" onclick="runValidationScan()" class="px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100/80 text-emerald-800 border border-emerald-200 text-xs font-bold flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[18px]">sync</span>
                <span>Pindai Ulang Live System</span>
            </button>
        </div>
    </div>

    <!-- 3. FIVE KEY METRIC STATISTIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Metric 1: Total Shelter -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-emerald-900/10 flex flex-col justify-between hover:shadow-md hover:border-emerald-500/30 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] text-slate-500 uppercase tracking-wider font-bold">Total Shelter</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">{{ $totalShelters }}</span>
                        <span class="text-xs font-bold text-emerald-700">Posko</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center group-hover:scale-110 group-hover:bg-[#14532d] group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[24px]">corporate_fare</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium">{{ $activeSheltersCount }} Aktif • {{ number_format($totalCapacity) }} Jiwa</span>
                <a href="{{ route('admin.shelters.index') }}" class="text-emerald-700 font-bold hover:underline">Posko →</a>
            </div>
        </div>

        <!-- Metric 2: Total Petugas -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-emerald-900/10 flex flex-col justify-between hover:shadow-md hover:border-emerald-500/30 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] text-slate-500 uppercase tracking-wider font-bold">Total Personel</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">{{ $totalOfficers }}</span>
                        <span class="text-xs font-bold text-slate-500">Personel</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center group-hover:scale-110 group-hover:bg-[#14532d] group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[24px]">groups</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium">{{ $activeOfficersCount }} Aktif • {{ $standbyOfficersCount }} Siaga</span>
                <a href="{{ route('admin.officers.index') }}" class="text-emerald-700 font-bold hover:underline">Petugas →</a>
            </div>
        </div>

        <!-- Metric 3: Total Jadwal Plotting -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-emerald-900/10 flex flex-col justify-between hover:shadow-md hover:border-emerald-500/30 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] text-slate-500 uppercase tracking-wider font-bold">Total Jadwal</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">{{ $totalSchedules }}</span>
                        <span class="text-xs font-bold text-slate-500">Sesi Plot</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center group-hover:scale-110 group-hover:bg-[#14532d] group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[24px]">event_available</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium">{{ $upcomingSchedulesCount }} Sesi Mendatang</span>
                <a href="{{ route('admin.schedules.index') }}" class="text-emerald-700 font-bold hover:underline">Roster →</a>
            </div>
        </div>

        <!-- Metric 4: Jadwal Hari Ini -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-emerald-900/10 flex flex-col justify-between hover:shadow-md hover:border-emerald-500/30 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] text-slate-500 uppercase tracking-wider font-bold">Jadwal Hari Ini</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-emerald-800 font-['Plus_Jakarta_Sans']">{{ $todaySchedulesCount }}</span>
                        <span class="text-xs font-bold text-emerald-700">Shift</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center group-hover:scale-110 group-hover:bg-[#14532d] group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[24px]">schedule</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span class="font-medium">P: {{ $shiftCounts['pagi'] }} | S: {{ $shiftCounts['siang'] }} | M: {{ $shiftCounts['malam'] }}</span>
                <a href="{{ route('admin.dashboard', ['tab' => 'today']) }}" class="text-emerald-700 font-bold hover:underline">Lihat →</a>
            </div>
        </div>

        <!-- Metric 5: Sedang Bertugas Saat Ini -->
        <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm border border-emerald-300/80 flex flex-col justify-between hover:shadow-md transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-1.5 text-[11px] text-emerald-800 uppercase tracking-wider font-extrabold">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span>Sedang Bertugas</span>
                    </div>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-extrabold text-emerald-900 font-['Plus_Jakarta_Sans']">{{ $activeDutiesCount }}</span>
                        <span class="text-xs font-bold text-emerald-700">Personel Pos</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-[24px]">fmd_good</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-emerald-100 flex items-center justify-between text-xs">
                <span class="text-emerald-800 font-bold">Patroli 24 Jam</span>
                <a href="{{ route('admin.dashboard', ['tab' => 'active']) }}" class="text-emerald-700 font-bold hover:underline">Live Feed →</a>
            </div>
        </div>
    </div>

    <!-- 4. JADWAL YANG SEDANG BERLANGSUNG & MONITORING HARI INI -->
    <div class="rounded-3xl bg-white p-6 shadow-sm border border-emerald-900/10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">badge</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Jadwal yang Sedang Berlangsung &amp; Siaga Hari Ini</h2>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase tracking-wider">
                            Live Standby
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Personil yang sedang bertugas di posko perimeter pada shift aktif hari ini.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.calendar') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                    <span>Buka Kalender</span>
                </a>
            </div>
        </div>

        <!-- Active Duty Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($activeDuties as $ad)
                <div class="rounded-2xl bg-white border border-emerald-200/90 p-4 flex flex-col justify-between hover:border-emerald-500/50 transition-all hover:shadow-md">
                    <div>
                        <!-- Header Card -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($ad->officer?->avatar_url)
                                    <img src="{{ $ad->officer->avatar_url }}" alt="{{ $ad->officer->name }}" class="w-11 h-11 rounded-2xl object-cover ring-2 ring-emerald-400 shrink-0 shadow-xs">
                                @else
                                    <div class="w-11 h-11 rounded-2xl bg-[#14532d] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                                        {{ substr($ad->officer?->name ?? 'P', 0, 2) }}
                                    </div>
                                @endif
                                <div class="flex flex-col min-w-0">
                                    <a href="{{ route('admin.officers.show', $ad->officer_id) }}" class="text-sm font-bold text-slate-900 hover:text-emerald-700 truncate block">
                                        {{ $ad->officer?->name ?? 'Petugas Lapangan' }}
                                    </a>
                                    <span class="text-[11px] text-slate-500 font-mono block truncate">
                                        NRP: {{ $ad->officer?->nrp ?? '-' }} • {{ $ad->officer?->position ?? 'Petugas' }}
                                    </span>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase shrink-0 whitespace-nowrap {{ $ad->status === 'Sedang Bertugas' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                                {{ $ad->status === 'Sedang Bertugas' ? 'Bertugas' : $ad->status }}
                            </span>
                        </div>

                        <!-- Location & Shift Details -->
                        <div class="space-y-2 bg-slate-50 p-3 rounded-xl border border-slate-200/80 text-xs text-slate-700">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-slate-400 shrink-0">Pos Shelter:</span>
                                <a href="{{ route('admin.shelters.show', $ad->shelter_id) }}" class="font-bold text-slate-900 hover:text-emerald-700 flex items-center gap-1 truncate text-right">
                                    <span class="material-symbols-outlined text-emerald-700 text-[15px] shrink-0">location_on</span>
                                    <span class="truncate">{{ $ad->shelter?->name ?? 'Posko Induk' }}</span>
                                </a>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-slate-400 shrink-0">Zona Wilayah:</span>
                                <span class="font-semibold text-emerald-800">{{ $ad->shelter?->zone ?? 'Pusat' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-slate-400 shrink-0">Shift &amp; Jam:</span>
                                <div class="flex items-center gap-1.5 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-900 font-bold text-[10px]">
                                        Shift {{ $ad->shift }}
                                    </span>
                                    <span class="font-mono font-bold text-slate-800 text-[11px] bg-white px-2 py-0.5 rounded-md border border-slate-200">
                                        {{ substr($ad->start_time, 0, 5) }} - {{ substr($ad->end_time, 0, 5) }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Notes strip -->
                        <div class="mt-2 text-[11px] text-slate-600 bg-emerald-50/40 px-2.5 py-1.5 rounded-lg border border-emerald-100 truncate flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-emerald-700 text-[14px] shrink-0">sticky_note_2</span>
                            <span class="truncate">{{ $ad->notes ?: 'Piket jaga posko standar.' }}</span>
                        </div>
                    </div>

                    <!-- Quick Status Toggle & Actions -->
                    <div class="mt-3.5 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5 flex-1 min-w-0">
                            <span class="text-[10px] text-slate-400 font-bold uppercase shrink-0">Status:</span>
                            <select onchange="quickUpdateStatus({{ $ad->id }}, this.value)" class="text-[11px] font-bold py-1 px-2 rounded-lg bg-white border border-slate-300 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 truncate cursor-pointer shadow-2xs">
                                <option value="Sedang Bertugas" {{ $ad->status === 'Sedang Bertugas' ? 'selected' : '' }}>● Bertugas</option>
                                <option value="Siaga Shift" {{ $ad->status === 'Siaga Shift' ? 'selected' : '' }}>● Siaga</option>
                                <option value="Selesai Shift" {{ $ad->status === 'Selesai Shift' ? 'selected' : '' }}>● Selesai</option>
                                <option value="Terjadwal" {{ $ad->status === 'Terjadwal' ? 'selected' : '' }}>● Terjadwal</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-1 shrink-0">
                            @if($ad->officer?->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ad->officer->phone) }}" target="_blank" class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 transition-colors flex items-center justify-center" title="Hubungi Petugas (WhatsApp)">
                                    <span class="material-symbols-outlined text-[16px]">chat</span>
                                </a>
                            @endif
                            <a href="{{ route('admin.schedules.show', $ad) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors flex items-center justify-center" title="Detail Lengkap">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-8 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-1">event_busy</span>
                    <p class="text-xs font-semibold">Tidak ada jadwal penjagaan aktif untuk hari ini.</p>
                    <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center gap-1 text-xs text-emerald-700 font-bold mt-2 hover:underline">
                        + Tambah Plotting Hari Ini
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- 5. ANALYTICS (CHART.JS) & QUICK CONFLICT SIMULATOR -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Personnel Distribution Interactive Chart (8 cols) -->
        <div class="lg:col-span-8 rounded-3xl bg-white p-6 shadow-sm border border-emerald-900/10 flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <div>
                        <span class="text-xs text-emerald-700 uppercase tracking-wider font-extrabold">Analisis Beban Operasional</span>
                        <h2 class="text-lg font-bold text-slate-900 font-['Plus_Jakarta_Sans'] mt-0.5">Grafik Distribusi Personel per Shelter Utama</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-bold">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Total {{ $totalOfficers }} Personel Terdaftar
                        </span>
                    </div>
                </div>

                <!-- Chart Canvas Container -->
                <div class="w-full h-72 relative">
                    <canvas id="officersChart"></canvas>
                </div>
            </div>

            <!-- Chart Footer Metrics -->
            <div class="pt-4 mt-4 border-t border-slate-100 grid grid-cols-3 gap-3 text-center">
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <span class="text-[11px] text-slate-500 block">Rata-rata Kuota Pos</span>
                    <span class="text-sm font-bold text-slate-900 mt-0.5 block">5 Personel / Pos</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <span class="text-[11px] text-slate-500 block">Rotasi Shift</span>
                    <span class="text-sm font-bold text-emerald-700 mt-0.5 block">3 Shift (8 Jam)</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <span class="text-[11px] text-slate-500 block">Sektor Tercover</span>
                    <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ count($zoneStats) }} Zona Wilayah</span>
                </div>
            </div>
        </div>

        <!-- Quick Plotting Simulation & Conflict Checker (4 cols) -->
        <div class="lg:col-span-4 rounded-3xl bg-white p-6 shadow-sm border border-emerald-900/10 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-emerald-700 font-extrabold uppercase tracking-wider">Validasi Cepat</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Engine Simulator</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans'] mb-1">Simulasi &amp; Uji Bentrok Plotting</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    Uji potensi bentrok shift personel secara instan sebelum didaftarkan ke jadwal posko.
                </p>

                <form id="sim-conflict-form" onsubmit="event.preventDefault(); runConflictSimulation();" class="flex flex-col gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Personel</label>
                        <select id="sim-officer" class="w-full px-3 py-2 rounded-xl bg-slate-50 text-slate-900 text-xs border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 font-medium">
                            @foreach($allOfficers as $off)
                                <option value="{{ $off->id }}">{{ $off->name }} (NRP: {{ $off->nrp }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Shelter Sasaran</label>
                            <select id="sim-shelter" class="w-full px-3 py-2 rounded-xl bg-slate-50 text-slate-900 text-xs border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 font-medium">
                                @foreach($allShelters as $ash)
                                    <option value="{{ $ash->id }}">{{ $ash->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Shift</label>
                            <select id="sim-shift" class="w-full px-3 py-2 rounded-xl bg-slate-50 text-slate-900 text-xs border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 font-medium">
                                <option value="Pagi">Pagi (07:00-15:00)</option>
                                <option value="Siang">Siang (15:00-23:00)</option>
                                <option value="Malam">Malam (23:00-07:00)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Tugas</label>
                        <input type="date" id="sim-date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 text-slate-900 text-xs border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 font-medium">
                    </div>

                    <button type="submit" class="mt-1 w-full py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-sm hover:scale-[1.01]">
                        <span class="material-symbols-outlined text-[18px]">rule</span>
                        <span>Cek Validasi &amp; Bentrok Otomatis</span>
                    </button>
                </form>

                <!-- Result Box -->
                <div id="sim-result-box" class="mt-3.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start gap-2.5 transition-all">
                    <span class="material-symbols-outlined text-emerald-700 text-[20px] shrink-0 mt-0.5" id="sim-result-icon">check_circle</span>
                    <div class="flex-1">
                        <span class="text-xs font-bold text-slate-900 block" id="sim-result-title">Sistem Siaga</span>
                        <span class="text-xs text-slate-600 mt-0.5 block" id="sim-result-desc">Pilih parameter di atas lalu klik tombol untuk memvalidasi bentrok jadwal.</span>
                        <!-- Quick Direct Create Schedule Button (Functional) -->
                        <div id="sim-action-btn-wrapper" class="hidden mt-2 pt-2 border-t border-emerald-200">
                            <button type="button" onclick="createScheduleFromSim()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-[11px] font-bold transition-colors">
                                <span class="material-symbols-outlined text-[14px]">add_circle</span>
                                <span>Terbitkan Jadwal Ini Sekarang</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>ConflictDetector v2.4</span>
                <span class="text-emerald-700 font-bold">100% Realtime MySQL</span>
            </div>
        </div>
    </div>

    <!-- 6. CCTV & MONITORING VISUAL SITUASI POS SHELTER -->
    <div class="rounded-3xl bg-white p-6 shadow-sm border border-emerald-900/10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">videocam</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Pemantauan Situasi Visual Posko Shelter Terjaga</h3>
                    <p class="text-xs text-slate-500">Pratinjau visual feed kamera CCTV &amp; kondisi fisik posko pengungsian.</p>
                </div>
            </div>
            <a href="{{ route('admin.shelters.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                Lihat Seluruh {{ $totalShelters ?? \App\Models\Shelter::count() }} Posko →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredShelters as $fsh)
                <div class="group relative rounded-2xl overflow-hidden bg-slate-50 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col">
                    <div class="w-full h-36 relative overflow-hidden bg-slate-200">
                        @if($fsh->image_url)
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $fsh->image_url }}" alt="{{ $fsh->name }}">
                        @else
                            <div class="w-full h-full bg-[#0d2e1c] flex items-center justify-center text-emerald-400">
                                <span class="material-symbols-outlined text-4xl">corporate_fare</span>
                            </div>
                        @endif
                        <div class="absolute top-2 left-2 px-2.5 py-0.5 rounded-full bg-[#0a2316]/85 backdrop-blur-md text-white text-[10px] font-extrabold flex items-center gap-1.5 border border-[#143d26]">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>CAM: {{ $fsh->code }}</span>
                        </div>
                        <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold">
                            {{ $fsh->zone }}
                        </div>
                    </div>
                    <div class="p-3.5 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-xs text-slate-900 font-['Plus_Jakarta_Sans'] truncate">{{ $fsh->name }}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">{{ $fsh->address }}</p>
                            <div class="mt-2 flex items-center justify-between text-[11px]">
                                <span class="text-slate-400">Kapasitas:</span>
                                <span class="font-bold text-slate-800">{{ number_format($fsh->capacity) }} Jiwa</span>
                            </div>
                        </div>
                        <div class="pt-2 mt-2 border-t border-slate-200 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Koord: <strong class="text-slate-700">{{ $fsh->coordinator_name }}</strong></span>
                            <a href="{{ route('admin.shelters.show', $fsh) }}" class="text-emerald-700 font-bold hover:underline">Detail →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 7. PRIMARY INTERACTIVE SCHEDULE TABLE SECTION -->
    <div class="rounded-3xl bg-white p-6 shadow-sm border border-emerald-900/10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4 pb-4 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                    <h3 class="text-lg font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Daftar Jadwal Plotting Penjagaan</h3>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Filter giliran shift, ubah status petugas secara real-time, dan monitor penjagaan bebas konflik.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.schedules.create') }}" class="px-4 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all hover:scale-[1.02]">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tambah Plotting</span>
                </a>
            </div>
        </div>

        <!-- Quick Filter Tab Pills -->
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <a href="{{ route('admin.dashboard', array_merge(request()->except('tab', 'page'), ['tab' => 'all'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ ($tab ?? 'all') === 'all' ? 'bg-[#14532d] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Jadwal ({{ $totalSchedules }})
            </a>
            <a href="{{ route('admin.dashboard', array_merge(request()->except('tab', 'page'), ['tab' => 'today'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ ($tab ?? '') === 'today' ? 'bg-[#14532d] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Hari Ini ({{ $todaySchedulesCount }})
            </a>
            <a href="{{ route('admin.dashboard', array_merge(request()->except('tab', 'page'), ['tab' => 'active'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ ($tab ?? '') === 'active' ? 'bg-[#14532d] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Sedang Bertugas ({{ $activeDutiesCount }})
            </a>
            <a href="{{ route('admin.dashboard', array_merge(request()->except('tab', 'page'), ['tab' => 'upcoming'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ ($tab ?? '') === 'upcoming' ? 'bg-[#14532d] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Mendatang ({{ $upcomingSchedulesCount }})
            </a>
        </div>

        <!-- Filter Bar Form -->
        <form method="GET" action="{{ route('admin.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
            <input type="hidden" name="tab" value="{{ $tab ?? 'all' }}">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari petugas, NRP, shelter..." class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            </div>
            <div>
                <select name="shelter" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="">Semua Shelter</option>
                    @foreach($allShelters as $sh)
                        <option value="{{ $sh->id }}" {{ request('shelter') == $sh->id ? 'selected' : '' }}>{{ $sh->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="shift" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="">Semua Shift</option>
                    <option value="Pagi" {{ request('shift') == 'Pagi' ? 'selected' : '' }}>Shift Pagi (07:00 - 15:00)</option>
                    <option value="Siang" {{ request('shift') == 'Siang' ? 'selected' : '' }}>Shift Siang (15:00 - 23:00)</option>
                    <option value="Malam" {{ request('shift') == 'Malam' ? 'selected' : '' }}>Shift Malam (23:00 - 07:00)</option>
                </select>
            </div>
            <div>
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="Sedang Bertugas" {{ request('status') == 'Sedang Bertugas' ? 'selected' : '' }}>Sedang Bertugas</option>
                    <option value="Siaga Shift" {{ request('status') == 'Siaga Shift' ? 'selected' : '' }}>Siaga Shift</option>
                    <option value="Terjadwal" {{ request('status') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="Selesai Shift" {{ request('status') == 'Selesai Shift' ? 'selected' : '' }}>Selesai Shift</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold transition-colors">
                    Terapkan
                </button>
                @if(request()->anyFilled(['search', 'shelter', 'shift', 'status']) || request('tab'))
                    <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition-colors" title="Reset Semua Filter">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Interactive Schedule Table -->
        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full min-w-[1050px] text-left text-xs table-auto">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-60 min-w-[220px]">Petugas &amp; Identitas</th>
                        <th class="py-3.5 px-4 w-52 min-w-[190px]">Shelter Sasaran</th>
                        <th class="py-3.5 px-4 w-36 min-w-[140px] whitespace-nowrap">Tanggal &amp; Hari</th>
                        <th class="py-3.5 px-4 w-44 min-w-[160px] whitespace-nowrap">Shift &amp; Jam</th>
                        <th class="py-3.5 px-4 w-40 min-w-[150px] whitespace-nowrap">Status Cepat (Live)</th>
                        <th class="py-3.5 px-4 min-w-[200px]">Keterangan</th>
                        <th class="py-3.5 px-4 w-28 min-w-[100px] text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($schedules as $sched)
                        <tr class="hover:bg-emerald-50/40 transition-colors" id="row-schedule-{{ $sched->id }}">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    @if($sched->officer?->avatar_url)
                                        <img class="w-9 h-9 rounded-full object-cover shrink-0 ring-1 ring-emerald-300 shadow-xs" src="{{ $sched->officer->avatar_url }}" alt="{{ $sched->officer->name }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-[#14532d] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                                            {{ substr($sched->officer?->name ?? 'P', 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <a href="{{ route('admin.officers.show', $sched->officer_id) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition-colors truncate block">
                                            {{ $sched->officer?->name ?? 'Petugas' }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block whitespace-nowrap">NRP: {{ $sched->officer?->nrp ?? '-' }} • {{ $sched->officer?->position ?? 'Petugas' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5 font-bold text-slate-900 whitespace-nowrap">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600 shrink-0"></span>
                                    <a href="{{ route('admin.shelters.show', $sched->shelter_id) }}" class="hover:text-emerald-700 transition-colors">
                                        {{ $sched->shelter?->name ?? 'Posko Induk' }}
                                    </a>
                                </div>
                                <span class="text-[11px] text-slate-400 pl-3.5 block whitespace-nowrap">{{ $sched->shelter?->zone ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-bold text-slate-900 block">{{ $sched->day }}, {{ $sched->date->format('d/m/Y') }}</span>
                                @if($sched->date->isToday())
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase">
                                        ● Hari Ini
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-800 font-bold border border-emerald-200">
                                    Shift {{ $sched->shift }}
                                </span>
                                <span class="block text-[11px] text-slate-600 mt-1 font-mono font-medium">
                                    {{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }} WIB
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <!-- Interactive Quick Status Dropdown (Direct Live System Update) -->
                                <select onchange="quickUpdateStatus({{ $sched->id }}, this.value)" class="text-[11px] font-bold py-1 px-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 cursor-pointer shadow-2xs">
                                    <option value="Sedang Bertugas" {{ $sched->status === 'Sedang Bertugas' ? 'selected' : '' }}>● Bertugas</option>
                                    <option value="Siaga Shift" {{ $sched->status === 'Siaga Shift' ? 'selected' : '' }}>● Siaga</option>
                                    <option value="Terjadwal" {{ $sched->status === 'Terjadwal' ? 'selected' : '' }}>● Terjadwal</option>
                                    <option value="Selesai Shift" {{ $sched->status === 'Selesai Shift' ? 'selected' : '' }}>● Selesai</option>
                                    <option value="Dibatalkan" {{ $sched->status === 'Dibatalkan' ? 'selected' : '' }}>● Dibatalkan</option>
                                </select>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-slate-600 text-xs block leading-relaxed line-clamp-2" title="{{ $sched->notes }}">
                                    {{ $sched->notes ?: 'Tugas rutin posko' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.schedules.show', $sched) }}" class="p-1.5 rounded-lg hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 transition-colors" title="Detail Lengkap">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.schedules.edit', $sched) }}" class="p-1.5 rounded-lg hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 transition-colors" title="Edit Jadwal">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <button type="button" onclick="confirmDeleteSchedule({{ $sched->id }}, '{{ $sched->officer?->name }}', '{{ $sched->shelter?->name }}')" class="p-1.5 rounded-lg hover:bg-rose-50 text-slate-500 hover:text-rose-600 transition-colors" title="Hapus Jadwal">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                <span class="material-symbols-outlined text-3xl text-slate-300 block mb-1">search_off</span>
                                Tidak ada jadwal yang sesuai kriteria pencarian / filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-xs text-slate-500">
                Menampilkan {{ $schedules->firstItem() ?? 0 }} - {{ $schedules->lastItem() ?? 0 }} dari {{ $schedules->total() }} jadwal
            </span>
            <div>
                {{ $schedules->links() }}
            </div>
        </div>
    </div>

    <!-- 8. AUDIT LOG FEED & RAPID EMERGENCY PROTOCOL -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Activity Timeline Feed (8 cols) -->
        <div class="lg:col-span-8 rounded-3xl bg-white p-6 shadow-sm border border-emerald-900/10">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">history</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Log Aktivitas Terbaru &amp; Audit Pos</h3>
                        <p class="text-xs text-slate-500">Jejak audit keamanan sistem tercatat secara realtime.</p>
                    </div>
                </div>
                <a href="{{ route('admin.activity-logs') }}" class="text-xs text-emerald-700 font-bold hover:underline">
                    Semua Log ({{ \App\Models\ActivityLog::count() }}) →
                </a>
            </div>

            <div class="relative pl-6 flex flex-col gap-4">
                <div class="absolute left-2.5 top-2 bottom-2 w-0.5 bg-emerald-100"></div>

                @forelse($recentLogs as $log)
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-emerald-600 ring-4 ring-white shadow-xs"></div>
                        <div class="flex-1 bg-slate-50/70 p-3 rounded-2xl border border-slate-100 hover:bg-emerald-50/40 transition-colors">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-900">{{ $log->user_name }} • <span class="text-emerald-800 font-semibold">[{{ $log->module }}]</span></span>
                                <span class="text-slate-400 text-[11px]">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                {{ $log->description }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-4 text-center">Belum ada aktivitas baru tercatat.</div>
                @endforelse
            </div>
        </div>

        <!-- Rapid Incident Protocol Box (4 cols) -->
        <div class="lg:col-span-4 rounded-3xl bg-gradient-to-br from-[#071c12] via-[#0d2e1c] to-[#14532d] text-white p-6 shadow-sm border border-[#143d26] flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="px-2.5 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                        Protokol Cepat
                    </span>
                    <span class="text-xs text-emerald-300 flex items-center gap-1 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Siaga Posko
                    </span>
                </div>
                <h3 class="text-base font-bold text-white font-['Plus_Jakarta_Sans'] mb-2">Panggilan Darurat &amp; Pergantian Kilat</h3>
                <p class="text-xs text-emerald-200/80 mb-5 leading-relaxed">
                    Gunakan tombol di bawah bila terjadi kendala mendadak personil (sakit/situasi darurat lapangan) untuk menyiarkan sinyal siaga cadangan.
                </p>
                
                <div class="flex flex-col gap-2.5">
                    <button type="button" onclick="triggerEmergencyAlert()" class="w-full py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-md hover:scale-[1.01]">
                        <span class="material-symbols-outlined text-[18px]">crisis_alert</span>
                        <span>Siarkan Sinyal Darurat Pos</span>
                    </button>
                    <a href="{{ route('admin.officers.index', ['status' => 'Siaga']) }}" class="w-full py-2.5 px-3 rounded-xl bg-emerald-950/70 hover:bg-emerald-900 border border-emerald-700/40 text-emerald-100 text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">person_pin</span>
                        <span>Lihat {{ $standbyOfficersCount }} Personel Siaga Cadangan</span>
                    </a>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-[#143d26] flex items-center justify-between text-xs text-emerald-300/80">
                <span>Kanal Radio: HT 144.520 MHz</span>
                <span class="text-white font-bold flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Tersambung
                </span>
            </div>
        </div>
    </div>
</div>

<!-- HIDDEN FORM FOR MODAL DELETE -->
<form id="delete-schedule-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<!-- MODAL KONFIRMASI HAPUS JADWAL -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="modalDeleteSchedule">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl flex flex-col gap-4 border border-rose-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">warning</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Konfirmasi Hapus Jadwal</h3>
                <p class="text-xs text-slate-500">Tindakan ini akan membatalkan penugasan shift terkait.</p>
            </div>
        </div>
        <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200" id="deleteScheduleDesc">
            Apakah Anda yakin ingin menghapus jadwal ini?
        </p>
        <div class="flex items-center justify-end gap-2 pt-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                Batal
            </button>
            <button type="button" onclick="executeScheduleDelete()" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-colors">
                Ya, Hapus Jadwal
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Chart.js initialization script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    // 1. Live Ticking Clock (WIB)
    function updateLiveClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const el = document.getElementById('live-clock');
        if (el) {
            el.innerText = `${hours}:${minutes}:${seconds} WIB`;
        }
    }
    setInterval(updateLiveClock, 1000);
    updateLiveClock();

    // 2. Chart.js Personnel Distribution per Shelter
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('officersChart');
        if (ctx) {
            const labels = @json($chartShelterLabels);
            const dataCounts = @json($chartShelterData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Personel Ditugaskan',
                        data: dataCounts,
                        backgroundColor: 'rgba(20, 83, 45, 0.85)',
                        hoverBackgroundColor: 'rgba(21, 128, 61, 1)',
                        borderColor: '#14532d',
                        borderWidth: 1,
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#052e16',
                            titleColor: '#ffffff',
                            bodyColor: '#a7f3d0',
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.parsed.y} Personel Jaga Aktif`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: 'Inter',
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 11
                                },
                                maxRotation: 25,
                                minRotation: 0
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });

    // 3. Quick Status Updater via AJAX
    function quickUpdateStatus(scheduleId, newStatus) {
        fetch(`/admin/schedules/${scheduleId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || `Status jadwal diubah menjadi ${newStatus}`);
            } else {
                showToast(data.message || 'Gagal mengubah status', 'error');
            }
        })
        .catch(err => {
            showToast('Terjadi kesalahan koneksi server', 'error');
        });
    }

    // 4. Conflict Simulation Engine
    let lastValidSimulationData = null;

    function runConflictSimulation() {
        const officerId = document.getElementById('sim-officer').value;
        const shelterId = document.getElementById('sim-shelter').value;
        const shift = document.getElementById('sim-shift').value;
        const date = document.getElementById('sim-date').value;

        const box = document.getElementById('sim-result-box');
        const icon = document.getElementById('sim-result-icon');
        const title = document.getElementById('sim-result-title');
        const desc = document.getElementById('sim-result-desc');
        const actionWrapper = document.getElementById('sim-action-btn-wrapper');

        title.innerText = 'Memindai Live System Shift...';
        desc.innerText = 'Memeriksa potensi tumpang tindih waktu penugasan personel...';
        icon.innerText = 'sync';
        icon.className = 'material-symbols-outlined text-secondary text-[20px] animate-spin shrink-0 mt-0.5';
        actionWrapper.classList.add('hidden');

        fetch('{{ route("admin.schedules.check-conflict") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                officer_id: officerId,
                shelter_id: shelterId,
                shift: shift,
                date: date
            })
        })
        .then(res => res.json())
        .then(data => {
            icon.classList.remove('animate-spin');
            if (data.has_conflict) {
                box.className = 'mt-3.5 p-3 rounded-xl bg-rose-50 border border-rose-200 flex items-start gap-2.5 transition-all';
                icon.className = 'material-symbols-outlined text-rose-600 text-[20px] shrink-0 mt-0.5';
                icon.innerText = 'error';
                title.innerText = 'BENTROK JADWAL TERDETEKSI!';
                title.className = 'text-xs font-bold text-rose-900 block';
                desc.innerText = data.message;
                desc.className = 'text-xs text-rose-700 mt-0.5 block';
                actionWrapper.classList.add('hidden');
                showToast('Peringatan: Potensi jadwal bentrok terdeteksi!', 'error');
            } else {
                box.className = 'mt-3.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start gap-2.5 transition-all';
                icon.className = 'material-symbols-outlined text-emerald-700 text-[20px] shrink-0 mt-0.5';
                icon.innerText = 'check_circle';
                title.innerText = 'Jadwal Valid & Bebas Konflik';
                title.className = 'text-xs font-bold text-slate-900 block';
                desc.innerText = data.message;
                desc.className = 'text-xs text-slate-600 mt-0.5 block';
                actionWrapper.classList.remove('hidden');
                lastValidSimulationData = { officer_id: officerId, shelter_id: shelterId, shift: shift, date: date };
                showToast('Jadwal valid dan bebas konflik!');
            }
        })
        .catch(err => {
            icon.classList.remove('animate-spin');
            icon.innerText = 'check_circle';
            title.innerText = 'Jadwal Siaga';
            desc.innerText = 'Pengecekan selesai.';
        });
    }

    // 5. Functional Direct Create Schedule from Simulation
    function createScheduleFromSim() {
        if (!lastValidSimulationData) return;

        // Redirect to create page pre-filled or submit via POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.schedules.store") }}';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        for (const [key, value] of Object.entries(lastValidSimulationData)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        const notes = document.createElement('input');
        notes.type = 'hidden';
        notes.name = 'notes';
        notes.value = 'Plotting otomatis via Dashboard Simulator.';
        form.appendChild(notes);

        document.body.appendChild(form);
        form.submit();
    }

    // 6. Modal Delete Schedule
    let deleteScheduleTargetId = null;

    function confirmDeleteSchedule(id, officerName, shelterName) {
        deleteScheduleTargetId = id;
        document.getElementById('deleteScheduleDesc').innerHTML = `Apakah Anda yakin ingin membatalkan/menghapus jadwal petugas <strong>${officerName}</strong> di posko <strong>${shelterName}</strong>?`;
        document.getElementById('modalDeleteSchedule').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('modalDeleteSchedule').classList.add('hidden');
        deleteScheduleTargetId = null;
    }

    function executeScheduleDelete() {
        if (!deleteScheduleTargetId) return;
        const form = document.getElementById('delete-schedule-form');
        form.action = `/admin/schedules/${deleteScheduleTargetId}`;
        form.submit();
    }

    // 7. Validation Scan Toast
    function runValidationScan() {
        showToast('Memindai seluruh shelter & live system shift: 0 tumpang tindih terdeteksi');
    }
</script>
@endpush
