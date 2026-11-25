<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan {{ ucfirst($reportType) }} - Shelter Management System</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; color: #1e293b; background: #fff; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
            @page { margin: 1.5cm; size: A4 portrait; }
        }
    </style>
</head>
<body class="p-8 max-w-5xl mx-auto">

    <!-- Action Bar (Hidden when printed) -->
    <div class="no-print mb-8 p-4 bg-slate-100 rounded-2xl flex items-center justify-between border border-slate-200">
        <div>
            <span class="text-xs font-bold text-slate-800 block">Dokumen Pratinjau Cetak / PDF</span>
            <span class="text-[11px] text-slate-500">Gunakan dialog cetak browser Anda untuk menyimpan sebagai PDF atau mencetak ke printer.</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.close()" class="px-4 py-2 rounded-xl bg-white border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">
                Tutup Jendela
            </button>
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] shadow-sm">
                Cetak / Ekspor PDF Sekarang
            </button>
        </div>
    </div>

    <!-- Official Header / Letterhead -->
    <div class="border-b-2 border-slate-900 pb-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Taman Safari Indonesia Logo" class="h-16 w-auto object-contain">
            <div>
                <h1 class="text-lg font-extrabold uppercase tracking-tight text-slate-900 leading-tight">SHELTER MANAGEMENT SYSTEM</h1>
                <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider">TAMAN SAFARI BOGOR • PENJAGAAN SATWA &amp; BENCANA TERPADU</p>
                <p class="text-[11px] text-slate-500 mt-0.5">{{ \App\Models\Setting::get('command_center_address', 'Gedung Pusat Operasi Wilayah, Jl. Konservasi No. 45 Jakarta') }} • Hotline: {{ \App\Models\Setting::get('hotline_toll_free', '1500 - 8989') }}</p>
            </div>
        </div>
        <div class="text-right text-[11px] text-slate-500">
            <span class="font-bold text-slate-800 block uppercase">Lembar Resmi Posko</span>
            <span>Ref: OPS/DOC/{{ date('Ymd/His') }}</span>
        </div>
    </div>

    <!-- Title & Period Meta -->
    <div class="mb-6">
        <h2 class="text-base font-bold uppercase text-slate-900 tracking-wide text-center underline">
            LAPORAN REKAPITULASI {{ strtoupper($reportType === 'schedule' ? 'JADWAL PLOTTING PENJAGAAN' : ($reportType === 'officer' ? 'PERSONEL PETUGAS LAPANGAN' : 'DATA MASTER POSKO SHELTER')) }}
        </h2>
        <div class="mt-3 flex flex-wrap items-center justify-between text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200">
            <div>
                <span class="font-bold text-slate-800">Periode:</span> {{ Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
            </div>
            @if($shelter)
                <div>
                    <span class="font-bold text-slate-800">Filter Posko:</span> {{ $shelter->name }} ({{ $shelter->zone }})
                </div>
            @endif
            @if($shift !== 'all')
                <div>
                    <span class="font-bold text-slate-800">Shift:</span> Shift {{ $shift }}
                </div>
            @endif
            <div>
                <span class="font-bold text-slate-800">Waktu Cetak:</span> {{ date('d/m/Y H:i') }} WIB
            </div>
        </div>
    </div>

    <!-- Content Table -->
    <div class="mb-8">
        @if($reportType === 'schedule')
            <table class="w-full text-left text-xs border border-slate-300 border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-900 font-bold border-b border-slate-300">
                        <th class="py-2.5 px-3 border-r border-slate-300 text-center w-10">No</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Tanggal / Hari</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Shift &amp; Jam</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Pos Shelter</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Nama Petugas Terplot</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Status</th>
                        <th class="py-2.5 px-3">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($data as $idx => $row)
                        <tr>
                            <td class="py-2 px-3 border-r border-slate-200 text-center text-slate-500">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-semibold">{{ $row->date->format('d/m/Y') }} ({{ $row->day }})</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-mono">Shift {{ $row->shift }} ({{ substr($row->start_time, 0, 5) }}-{{ substr($row->end_time, 0, 5) }})</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-bold">{{ $row->shelter?->name ?? '-' }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->officer?->name ?? '-' }} ({{ $row->officer?->nrp ?? '-' }})</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-semibold">{{ $row->status }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $row->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($reportType === 'officer')
            <table class="w-full text-left text-xs border border-slate-300 border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-900 font-bold border-b border-slate-300">
                        <th class="py-2.5 px-3 border-r border-slate-300 text-center w-10">No</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">NRP / NIP</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Nama Personel</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Jabatan</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Penempatan Pos</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Telepon</th>
                        <th class="py-2.5 px-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($data as $idx => $row)
                        <tr>
                            <td class="py-2 px-3 border-r border-slate-200 text-center text-slate-500">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-mono font-bold">{{ $row->nrp }}</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-bold">{{ $row->name }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->position }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->shelter?->name ?? 'Posko Induk' }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->phone ?? '-' }}</td>
                            <td class="py-2 px-3 font-semibold">{{ $row->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <table class="w-full text-left text-xs border border-slate-300 border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-900 font-bold border-b border-slate-300">
                        <th class="py-2.5 px-3 border-r border-slate-300 text-center w-10">No</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Kode</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Nama Shelter</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Zona</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Koordinator</th>
                        <th class="py-2.5 px-3 border-r border-slate-300">Kapasitas</th>
                        <th class="py-2.5 px-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($data as $idx => $row)
                        <tr>
                            <td class="py-2 px-3 border-r border-slate-200 text-center text-slate-500">{{ $idx + 1 }}</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-mono font-bold">{{ $row->code }}</td>
                            <td class="py-2 px-3 border-r border-slate-200 font-bold">{{ $row->name }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->zone }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->coordinator_name }}</td>
                            <td class="py-2 px-3 border-r border-slate-200">{{ $row->current_occupancy }} / {{ $row->capacity }} Jiwa</td>
                            <td class="py-2 px-3 font-semibold">{{ ucfirst(str_replace('_', ' ', $row->status)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    <!-- Signatures Block -->
    <div class="grid grid-cols-2 gap-8 text-xs pt-8">
        <div>
            <span class="block text-slate-500 mb-12">Mengetahui,<br>Komandan Operasional Posko Utama</span>
            <span class="font-bold text-slate-900 block underline">Letkol Inf. H. Suryadi, M.Han</span>
            <span class="text-slate-500 text-[11px]">NRP: 197808122001121002</span>
        </div>
        <div class="text-right">
            <span class="block text-slate-500 mb-12">Jakarta, {{ date('d F Y') }}<br>Petugas Verifikator Data Roster</span>
            <span class="font-bold text-slate-900 block underline">{{ auth()->user()->name }}</span>
            <span class="text-slate-500 text-[11px] uppercase">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
        </div>
    </div>

</body>
</html>

