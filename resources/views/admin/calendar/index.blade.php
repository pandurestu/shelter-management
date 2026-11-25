@extends('layouts.app')

@section('title', 'Kalender Penjagaan Shelter')
@section('page-title', 'Kalender Penjagaan')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header with Views & Month Navigation -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Kalender Penjagaan &amp; Plotting</h1>
            <p class="text-xs text-slate-500 mt-1">Visualisasi rotasi jadwal jaga bulanan, mingguan, dan harian di seluruh posko perimeter.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- View Type Switcher (Month, Week, Day) -->
            <div class="inline-flex p-1 rounded-xl bg-white border border-slate-200 text-xs shadow-sm">
                <a href="{{ route('admin.calendar', ['view' => 'month', 'month' => $currentDate->format('Y-m'), 'shelter_id' => $shelterId]) }}" class="px-3 py-1.5 rounded-lg {{ $viewType === 'month' ? 'bg-[#14532d] text-white font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                    Bulanan
                </a>
                <a href="{{ route('admin.calendar', ['view' => 'week', 'month' => $currentDate->format('Y-m'), 'shelter_id' => $shelterId]) }}" class="px-3 py-1.5 rounded-lg {{ $viewType === 'week' ? 'bg-[#14532d] text-white font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                    Mingguan
                </a>
                <a href="{{ route('admin.calendar', ['view' => 'day', 'month' => $currentDate->format('Y-m'), 'shelter_id' => $shelterId]) }}" class="px-3 py-1.5 rounded-lg {{ $viewType === 'day' ? 'bg-[#14532d] text-white font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                    Harian
                </a>
            </div>

            <!-- Month Navigator -->
            <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-xl p-1 shadow-sm">
                <a href="{{ route('admin.calendar', ['view' => $viewType, 'month' => $prevMonth, 'shelter_id' => $shelterId]) }}" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors" title="Bulan Sebelumnya">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </a>
                <span class="px-3 text-xs font-bold text-slate-900 font-['Plus_Jakarta_Sans']">
                    {{ $currentDate->translatedFormat('F Y') }}
                </span>
                <a href="{{ route('admin.calendar', ['view' => $viewType, 'month' => $nextMonth, 'shelter_id' => $shelterId]) }}" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors" title="Bulan Berikutnya">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </a>
            </div>

            <a href="{{ route('admin.schedules.create') }}" class="px-4 py-2 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all">
                <span class="material-symbols-outlined text-[16px]">add</span>
                <span>+ Plotting Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-emerald-900/10 mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <span class="text-xs font-bold text-slate-700 shrink-0">Filter Shelter:</span>
            <form method="GET" action="{{ route('admin.calendar') }}" class="flex-1 sm:w-72">
                <input type="hidden" name="view" value="{{ $viewType }}">
                <input type="hidden" name="month" value="{{ $currentDate->format('Y-m') }}">
                <select name="shelter_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Seluruh Shelter Terdata</option>
                    @foreach($shelters as $sh)
                        <option value="{{ $sh->id }}" {{ $shelterId == $sh->id ? 'selected' : '' }}>{{ $sh->name }} ({{ $sh->zone }})</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center gap-3 text-xs">
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span> Shift Pagi (07:00-15:00)
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Shift Siang (15:00-23:00)
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span> Shift Malam (23:00-07:00)
            </span>
        </div>
    </div>

    @if($viewType === 'month')
        <!-- MONTH VIEW -->
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-900/10 overflow-hidden mb-6">
            <!-- Day of Week Headers -->
            <div class="grid grid-cols-7 border-b border-slate-200 bg-emerald-50/60 text-center text-xs font-bold uppercase tracking-wider text-slate-700 py-3">
                <div>Senin</div>
                <div>Selasa</div>
                <div>Rabu</div>
                <div>Kamis</div>
                <div>Jumat</div>
                <div>Sabtu</div>
                <div>Minggu</div>
            </div>

            <!-- Calendar Days Grid -->
            <div class="grid grid-cols-7 divide-x divide-y divide-slate-100 text-xs">
                @foreach($calendarDays as $day)
                    <div class="min-h-[140px] p-2 flex flex-col justify-between transition-colors {{ $day['isCurrentMonth'] ? 'bg-white' : 'bg-slate-50/60 text-slate-400' }} {{ $day['isToday'] ? 'ring-2 ring-emerald-500 ring-inset bg-emerald-50/20' : '' }}">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-xs {{ $day['isToday'] ? 'w-6 h-6 rounded-full bg-emerald-700 text-white flex items-center justify-center font-extrabold shadow-xs' : ($day['isCurrentMonth'] ? 'text-slate-900' : 'text-slate-400') }}">
                                {{ $day['dayNumber'] }}
                            </span>
                            @if(count($day['schedules']) > 0)
                                <span class="text-[10px] text-emerald-800 font-extrabold bg-emerald-100 px-1.5 py-0.5 rounded-full">
                                    {{ count($day['schedules']) }}
                                </span>
                            @endif
                        </div>

                        <!-- Schedules Badges inside day cell: Max 3 visible, rest in '+X lainnya' button -->
                        <div class="flex flex-col gap-1 flex-1">
                            @foreach(array_slice($day['schedules'], 0, 3) as $sc)
                                @php
                                    $badgeColor = $sc->shift === 'Pagi' ? 'bg-emerald-50 border-emerald-300 text-emerald-900 hover:bg-emerald-100' : ($sc->shift === 'Siang' ? 'bg-blue-50 border-blue-300 text-blue-900 hover:bg-blue-100' : 'bg-purple-50 border-purple-300 text-purple-900 hover:bg-purple-100');
                                @endphp
                                <button type="button" onclick="showCalendarDutyModal('{{ addslashes($sc->shelter?->name) }}', '{{ addslashes($sc->officer?->name) }}', 'Shift {{ $sc->shift }}', '{{ substr($sc->start_time, 0, 5) }} - {{ substr($sc->end_time, 0, 5) }} WIB', '{{ $sc->day }}, {{ $sc->date->format('d M Y') }}', '{{ $sc->status }}', '{{ addslashes($sc->notes ?? 'Piket jaga posko standar.') }}')"
                                    class="w-full text-left px-1.5 py-1 rounded-md border text-[11px] font-medium truncate {{ $badgeColor }} transition-all shadow-2xs block" title="{{ $sc->officer?->name }} ({{ $sc->shelter?->name }})">
                                    <span class="font-bold font-mono">{{ substr($sc->start_time, 0, 5) }}</span>
                                    <span>{{ $sc->officer?->name ?? 'Petugas' }}</span>
                                </button>
                            @endforeach

                            @if(count($day['schedules']) > 3)
                                @php
                                    $remainingCount = count($day['schedules']) - 3;
                                    $allForDay = array_map(function($s) {
                                        return [
                                            'id' => $s->id,
                                            'officer' => $s->officer?->name ?? 'Petugas Lapangan',
                                            'nrp' => $s->officer?->nrp ?? '-',
                                            'position' => $s->officer?->position ?? 'Petugas',
                                            'shelter' => $s->shelter?->name ?? 'Posko Induk',
                                            'zone' => $s->shelter?->zone ?? '-',
                                            'shift' => $s->shift,
                                            'time' => substr($s->start_time, 0, 5) . ' - ' . substr($s->end_time, 0, 5) . ' WIB',
                                            'status' => $s->status,
                                            'notes' => $s->notes ?: 'Piket jaga posko standar.'
                                        ];
                                    }, $day['schedules']);
                                    $daySchedulesB64 = base64_encode(json_encode($allForDay));
                                @endphp
                                <button type="button" 
                                    data-date-title="{{ $day['date']->translatedFormat('l, d F Y') }}"
                                    data-date-ymd="{{ $day['dateString'] }}"
                                    data-schedules="{{ $daySchedulesB64 }}"
                                    onclick="handleShowDayAllSchedules(this)"
                                    class="w-full text-center py-1 px-1 rounded-md bg-emerald-100 hover:bg-emerald-200 text-emerald-900 font-extrabold text-[10px] transition-colors border border-emerald-300 shadow-2xs">
                                    +{{ $remainingCount }} jadwal lainnya
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @elseif($viewType === 'week')
        <!-- WEEK VIEW -->
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-900/10 overflow-hidden mb-6 p-6">
            <h3 class="text-base font-bold text-slate-900 mb-4 font-['Plus_Jakarta_Sans']">
                Jadwal Mingguan ({{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }})
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
                @foreach($calendarDays as $day)
                    <div class="rounded-xl border p-3 flex flex-col {{ $day['isToday'] ? 'bg-emerald-50/40 border-emerald-400' : 'bg-slate-50 border-slate-200' }}">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200 mb-2">
                            <span class="text-xs font-bold text-slate-800">{{ $day['date']->translatedFormat('l') }}</span>
                            <span class="text-xs font-extrabold text-slate-900">{{ $day['date']->format('d M') }}</span>
                        </div>
                        <div class="flex flex-col gap-2 overflow-y-auto max-h-96">
                            @forelse($day['schedules'] as $sc)
                                <div class="p-2.5 rounded-lg bg-white border border-slate-200 shadow-2xs text-xs flex flex-col gap-1 cursor-pointer hover:border-emerald-500 transition-colors"
                                    onclick="showCalendarDutyModal('{{ addslashes($sc->shelter?->name) }}', '{{ addslashes($sc->officer?->name) }}', 'Shift {{ $sc->shift }}', '{{ substr($sc->start_time, 0, 5) }} - {{ substr($sc->end_time, 0, 5) }} WIB', '{{ $sc->day }}, {{ $sc->date->format('d M Y') }}', '{{ $sc->status }}', '{{ addslashes($sc->notes ?? '') }}')">
                                    <span class="font-bold text-slate-900">{{ $sc->shelter?->name }}</span>
                                    <span class="text-emerald-800 font-semibold">{{ $sc->officer?->name }}</span>
                                    <span class="text-[10px] text-slate-500">Shift {{ $sc->shift }} • {{ substr($sc->start_time, 0, 5) }}-{{ substr($sc->end_time, 0, 5) }}</span>
                                </div>
                            @empty
                                <span class="text-[11px] text-slate-400 text-center py-4 italic">Kosong</span>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @else
        <!-- DAY VIEW -->
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-900/10 overflow-hidden mb-6 p-6">
            <h3 class="text-base font-bold text-slate-900 mb-4 font-['Plus_Jakarta_Sans']">
                Jadwal Harian: {{ $startDate->translatedFormat('l, d F Y') }}
            </h3>

            @php
                $daySchedules = $calendarDays[0]['schedules'] ?? [];
            @endphp

            <div class="space-y-3">
                @forelse($daySchedules as $sc)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-emerald-50/40 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#14532d] text-white flex items-center justify-center font-bold text-xs">
                                {{ substr($sc->officer?->name ?? 'P', 0, 2) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $sc->officer?->name }}</h4>
                                <span class="text-xs text-slate-500">NRP: {{ $sc->officer?->nrp }} • Penempatan: {{ $sc->shelter?->name }} ({{ $sc->shelter?->zone }})</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 text-xs">
                            <span class="px-3 py-1 rounded-full font-bold {{ $sc->shift === 'Pagi' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                Shift {{ $sc->shift }} ({{ substr($sc->start_time, 0, 5) }} - {{ substr($sc->end_time, 0, 5) }} WIB)
                            </span>
                            <span class="font-semibold text-slate-700">{{ $sc->status }}</span>
                            <a href="{{ route('admin.schedules.show', $sc) }}" class="text-emerald-700 font-bold hover:underline">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 text-xs">Tidak ada jadwal penjagaan tercatat untuk hari ini.</div>
                @endforelse
            </div>
        </div>
    @endif
</div>

<!-- Modal Detail Tugas Kalender -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" id="calDutyModal">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl flex flex-col gap-4 border border-emerald-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-emerald-800 font-bold text-xs uppercase">
                <span class="material-symbols-outlined text-[18px]">event_available</span>
                <span>Detail Jadwal Plotting</span>
            </div>
            <button class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200" onclick="closeCalModal()">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <div>
            <span class="text-[11px] text-slate-400 font-medium">Posko Shelter</span>
            <h3 class="text-lg font-bold text-slate-900 font-['Plus_Jakarta_Sans']" id="calShelter">Nama Shelter</h3>
        </div>

        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex flex-col gap-2 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-500">Petugas Jaga:</span>
                <span class="font-bold text-slate-900" id="calOfficer">-</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Tanggal Tugas:</span>
                <span class="font-semibold text-slate-800" id="calDate">-</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Shift &amp; Jam:</span>
                <span class="font-bold text-emerald-800" id="calShift">-</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Status Tugas:</span>
                <span class="font-bold text-emerald-700" id="calStatus">-</span>
            </div>
            <div class="pt-2 border-t border-emerald-200/50">
                <span class="text-slate-500 block mb-0.5">Catatan Operasional:</span>
                <span class="text-slate-700 italic" id="calNotes">-</span>
            </div>
        </div>

        <button type="button" class="w-full py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] shadow-sm transition-colors" onclick="closeCalModal()">
            Tutup Pratinjau
        </button>
    </div>
</div>

<!-- MODAL: DAFTAR SEMUA JADWAL PADA HARI TERTENTU -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" id="dayAllSchedulesModal">
    <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl flex flex-col gap-4 border border-emerald-200 max-h-[85vh]">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']" id="dayModalDate">Jadwal Penjagaan</h3>
                    <p class="text-xs text-slate-500" id="dayModalCount">Daftar personel bertugas pada tanggal ini.</p>
                </div>
            </div>
            <button class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors" onclick="closeDayAllSchedulesModal()">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Scrollable list of schedules -->
        <div class="flex flex-col gap-2.5 overflow-y-auto max-h-[55vh] pr-1" id="dayModalList">
            <!-- Dynamic JS insertion -->
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <a id="dayModalFullDayViewLink" href="#" class="px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#14532d] text-xs font-bold transition-colors flex items-center gap-1.5 border border-emerald-200">
                <span class="material-symbols-outlined text-[16px]">view_day</span>
                <span>Buka Tampilan Harian Penuh</span>
            </a>
            <button type="button" class="px-5 py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] shadow-sm transition-colors" onclick="closeDayAllSchedulesModal()">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function showCalendarDutyModal(shelter, officer, shift, time, date, status, notes) {
        document.getElementById('calShelter').innerText = shelter;
        document.getElementById('calOfficer').innerText = officer;
        document.getElementById('calShift').innerText = shift + ' (' + time + ')';
        document.getElementById('calDate').innerText = date;
        document.getElementById('calStatus').innerText = status;
        document.getElementById('calNotes').innerText = notes || 'Piket rutin pengawasan perimeter.';
        document.getElementById('calDutyModal').classList.remove('hidden');
    }

    function closeCalModal() {
        document.getElementById('calDutyModal').classList.add('hidden');
    }

    function handleShowDayAllSchedules(button) {
        const dateTitle = button.getAttribute('data-date-title');
        const dateYmd = button.getAttribute('data-date-ymd');
        const rawB64 = button.getAttribute('data-schedules');
        let schedules = [];
        try {
            const decoded = decodeURIComponent(escape(atob(rawB64)));
            schedules = JSON.parse(decoded);
        } catch(err) {
            console.error("Error parsing schedules:", err);
        }

        const fullViewBtn = document.getElementById('dayModalFullDayViewLink');
        if (fullViewBtn && dateYmd) {
            fullViewBtn.href = "{{ route('admin.calendar') }}?view=day&date=" + dateYmd;
        }

        openDayAllSchedulesModal(dateTitle, schedules);
    }

    function openDayAllSchedulesModal(dateTitle, schedules) {
        document.getElementById('dayModalDate').innerText = 'Jadwal Penjagaan - ' + dateTitle;
        document.getElementById('dayModalCount').innerText = schedules.length + ' penugasan shift terdaftar di berbagai posko perimeter.';
        
        const listContainer = document.getElementById('dayModalList');
        listContainer.innerHTML = '';

        schedules.forEach(item => {
            const shiftBadgeClass = item.shift === 'Pagi' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : (item.shift === 'Siang' ? 'bg-blue-50 text-blue-800 border-blue-300' : 'bg-purple-50 text-purple-800 border-purple-300');
            
            const card = document.createElement('div');
            card.className = 'p-3 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col gap-2 hover:bg-emerald-50/40 transition-colors';
            card.innerHTML = `
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-[#14532d] text-white flex items-center justify-center font-bold text-xs shrink-0">
                            ${item.officer.substring(0, 2).toUpperCase()}
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-xs text-slate-900">${item.officer}</span>
                            <span class="text-[10px] text-slate-500">NRP: ${item.nrp} • ${item.position}</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full border text-[10px] font-extrabold ${shiftBadgeClass}">
                        Shift ${item.shift}
                    </span>
                </div>
                <div class="bg-white p-2 rounded-xl border border-slate-200/80 text-[11px] grid grid-cols-2 gap-2">
                    <div>
                        <span class="text-slate-400 block text-[10px]">Posko Shelter:</span>
                        <span class="font-bold text-slate-800">${item.shelter} (${item.zone})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">Jam Tugas:</span>
                        <span class="font-mono font-bold text-slate-800">${item.time}</span>
                    </div>
                </div>
                ${item.notes ? `<div class="text-[11px] text-slate-500 italic px-1">"${item.notes}"</div>` : ''}
            `;
            listContainer.appendChild(card);
        });

        document.getElementById('dayAllSchedulesModal').classList.remove('hidden');
    }

    function closeDayAllSchedulesModal() {
        document.getElementById('dayAllSchedulesModal').classList.add('hidden');
    }
</script>
@endsection

