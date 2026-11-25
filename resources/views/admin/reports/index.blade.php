@extends('layouts.app')

@section('title', 'Laporan & Export')
@section('page-title', 'Pusat Laporan & Rekapitulasi')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Pusat Laporan &amp; Rekapitulasi</h1>
            <p class="text-xs text-slate-500 mt-1">Unduh spreadsheet Excel, pratinjau rekap penugasan, dan cetak dokumen resmi untuk audit posko.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold flex items-center gap-2 shadow-sm transition-all">
                <span class="material-symbols-outlined text-[18px] text-rose-600">print</span>
                <span>Cetak / Simpan PDF</span>
            </a>
            <a href="{{ route('admin.reports.export-excel', request()->all()) }}" class="px-4 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-2 shadow-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">table_view</span>
                <span>Unduh Spreadsheet Excel (.xls)</span>
            </a>
        </div>
    </div>

    <!-- Filter Configuration Card -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-emerald-900/10 mb-6">
        <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Laporan</label>
                <select name="type" onchange="this.form.submit()" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="schedule" {{ $reportType === 'schedule' ? 'selected' : '' }}>Laporan Jadwal Plotting</option>
                    <option value="officer" {{ $reportType === 'officer' ? 'selected' : '' }}>Laporan Personel Petugas</option>
                    <option value="shelter" {{ $reportType === 'shelter' ? 'selected' : '' }}>Laporan Data Master Shelter</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Filter Shelter</label>
                <select name="shelter_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Seluruh Shelter</option>
                    @foreach($shelters as $sh)
                        <option value="{{ $sh->id }}" {{ $shelterId == $sh->id ? 'selected' : '' }}>{{ $sh->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Shift</label>
                <div class="flex items-center gap-2">
                    <select name="shift" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="all">Semua Shift</option>
                        <option value="Pagi" {{ $shift === 'Pagi' ? 'selected' : '' }}>Pagi</option>
                        <option value="Siang" {{ $shift === 'Siang' ? 'selected' : '' }}>Siang</option>
                        <option value="Malam" {{ $shift === 'Malam' ? 'selected' : '' }}>Malam</option>
                    </select>
                    <button type="submit" class="p-2 rounded-xl bg-emerald-800 text-white hover:bg-emerald-900 transition-colors" title="Terapkan Filter">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Preview Table Container -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-emerald-900/10 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-700">preview</span>
                <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">
                    Pratinjau Data Laporan: {{ $reportType === 'schedule' ? 'Jadwal Plotting' : ($reportType === 'officer' ? 'Data Personel Petugas' : 'Data Master Shelter') }}
                </h3>
            </div>
            <span class="text-xs text-slate-500 font-semibold">Total {{ count($data) }} baris data ditemukan</span>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            @if($reportType === 'schedule')
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Tanggal &amp; Hari</th>
                            <th class="py-3 px-4">Shift &amp; Jam</th>
                            <th class="py-3 px-4">Posko Shelter</th>
                            <th class="py-3 px-4">Petugas Terplot</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        @forelse($data as $idx => $row)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 font-semibold">{{ $row->date->format('d/m/Y') }} ({{ $row->day }})</td>
                                <td class="py-3 px-4 font-mono">Shift {{ $row->shift }} ({{ substr($row->start_time, 0, 5) }} - {{ substr($row->end_time, 0, 5) }})</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $row->shelter?->name ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="font-bold text-slate-900 block">{{ $row->officer?->name ?? '-' }}</span>
                                    <span class="text-[10px] text-slate-400">NRP: {{ $row->officer?->nrp ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $row->status === 'Sedang Bertugas' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $row->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-500 max-w-xs truncate">{{ $row->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada jadwal pada rentang periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif($reportType === 'officer')
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">NRP / NIP</th>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-4">Jabatan</th>
                            <th class="py-3 px-4">Pos Penempatan</th>
                            <th class="py-3 px-4">Telepon</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Total Plotting</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        @forelse($data as $idx => $row)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 font-mono font-bold">{{ $row->nrp }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $row->name }}</td>
                                <td class="py-3 px-4">{{ $row->position }}</td>
                                <td class="py-3 px-4">{{ $row->shelter?->name ?? 'Posko Induk' }}</td>
                                <td class="py-3 px-4">{{ $row->phone ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $row->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $row->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-bold text-emerald-700">{{ $row->schedules_count ?? 0 }} Sesi</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-400">Tidak ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @else
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Kode Posko</th>
                            <th class="py-3 px-4">Nama Shelter</th>
                            <th class="py-3 px-4">Zona</th>
                            <th class="py-3 px-4">Koordinator</th>
                            <th class="py-3 px-4">Kapasitas</th>
                            <th class="py-3 px-4">Kuota Personel</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        @forelse($data as $idx => $row)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 font-mono font-bold">{{ $row->code }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $row->name }}</td>
                                <td class="py-3 px-4">{{ $row->zone }}</td>
                                <td class="py-3 px-4 font-semibold">{{ $row->coordinator_name }}</td>
                                <td class="py-3 px-4">{{ $row->current_occupancy }} / {{ $row->capacity }} Jiwa</td>
                                <td class="py-3 px-4">{{ $row->guard_quota }} Petugas / shift</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        {{ ucfirst(str_replace('_', ' ', $row->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-400">Tidak ada data shelter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

