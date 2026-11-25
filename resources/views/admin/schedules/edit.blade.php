@extends('layouts.app')

@section('title', 'Edit Plotting Jadwal')
@section('page-title', 'Edit Plotting')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.schedules.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Edit Plotting Jadwal Penjagaan</h1>
            <p class="text-xs text-slate-500">Perbarui penempatan shelter, pergantian personel, waktu shift, dan status tugas.</p>
        </div>
    </div>

    <!-- Live Conflict Detector Banner -->
    <div id="live-conflict-banner" class="hidden mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 shadow-sm flex items-start gap-3">
        <span class="material-symbols-outlined text-rose-600 text-[22px] shrink-0 mt-0.5">warning</span>
        <div class="flex-1">
            <h4 class="font-bold text-xs text-rose-900 font-['Plus_Jakarta_Sans']" id="conflict-title">Peringatan Jadwal Bentrok Terdeteksi!</h4>
            <p class="text-xs text-rose-700 mt-0.5" id="conflict-message"></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" id="schedule-form" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Shelter & Officer Select -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pos Shelter Sasaran <span class="text-rose-500">*</span></label>
                    <select name="shelter_id" id="shelter_id" required onchange="triggerConflictCheck()" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        @foreach($shelters as $sh)
                            <option value="{{ $sh->id }}" {{ old('shelter_id', $schedule->shelter_id) == $sh->id ? 'selected' : '' }}>
                                {{ $sh->name }} ({{ $sh->zone }} - {{ $sh->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Petugas yang Diplot <span class="text-rose-500">*</span></label>
                    <select name="officer_id" id="officer_id" required onchange="triggerConflictCheck()" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        @foreach($officers as $off)
                            <option value="{{ $off->id }}" {{ old('officer_id', $schedule->officer_id) == $off->id ? 'selected' : '' }}>
                                {{ $off->name }} (NRP: {{ $off->nrp }} - {{ $off->position }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date, Auto Day, Shift -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Penjagaan <span class="text-rose-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', $schedule->date->format('Y-m-d')) }}" required onchange="handleDateChange()" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Hari (Otomatis)</label>
                    <div class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-emerald-800 flex items-center justify-between">
                        <span id="auto-day-display">{{ $schedule->day }}</span>
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">event</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Shift <span class="text-rose-500">*</span></label>
                    <select name="shift" id="shift" required onchange="handleShiftChange()" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none font-bold text-slate-800">
                        <option value="Pagi" {{ old('shift', $schedule->shift) == 'Pagi' ? 'selected' : '' }}>Shift 1 - Pagi (07:00 - 15:00)</option>
                        <option value="Siang" {{ old('shift', $schedule->shift) == 'Siang' ? 'selected' : '' }}>Shift 2 - Siang (15:00 - 23:00)</option>
                        <option value="Malam" {{ old('shift', $schedule->shift) == 'Malam' ? 'selected' : '' }}>Shift 3 - Malam (23:00 - 07:00)</option>
                    </select>
                </div>
            </div>

            <!-- Start Time, End Time, Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jam Mulai Tugas <span class="text-rose-500">*</span></label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jam Selesai Tugas <span class="text-rose-500">*</span></label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Penugasan <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none font-semibold">
                        <option value="Terjadwal" {{ old('status', $schedule->status) == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Siaga Shift" {{ old('status', $schedule->status) == 'Siaga Shift' ? 'selected' : '' }}>Siaga Shift</option>
                        <option value="Sedang Bertugas" {{ old('status', $schedule->status) == 'Sedang Bertugas' ? 'selected' : '' }}>Sedang Bertugas</option>
                        <option value="Selesai Shift" {{ old('status', $schedule->status) == 'Selesai Shift' ? 'selected' : '' }}>Selesai Shift</option>
                        <option value="Dibatalkan" {{ old('status', $schedule->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan / Catatan Operasional Penjagaan</label>
                <textarea name="notes" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('notes', $schedule->notes) }}</textarea>
            </div>

            <!-- Status Indicator -->
            <div id="status-validation-badge" class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-700 text-[20px]" id="validation-icon">verified_user</span>
                    <span class="text-slate-800 font-semibold" id="validation-text">Validasi Otomatis: Parameter siap diverifikasi bebas bentrok.</span>
                </div>
                <span class="text-[11px] font-bold text-emerald-800" id="validation-tag">VALID</span>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.schedules.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" id="btn-submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">Perbarui Jadwal Plotting</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const currentScheduleId = {{ $schedule->id }};

    const shiftTimes = {
        'Pagi': { start: '07:00', end: '15:00' },
        'Siang': { start: '15:00', end: '23:00' },
        'Malam': { start: '23:00', end: '07:00' }
    };

    function handleDateChange() {
        const dateInput = document.getElementById('date').value;
        if (dateInput) {
            const d = new Date(dateInput);
            const dayName = dayNames[d.getDay()];
            document.getElementById('auto-day-display').innerText = dayName;
        }
        triggerConflictCheck();
    }

    function handleShiftChange() {
        const shiftVal = document.getElementById('shift').value;
        if (shiftTimes[shiftVal]) {
            document.getElementById('start_time').value = shiftTimes[shiftVal].start;
            document.getElementById('end_time').value = shiftTimes[shiftVal].end;
        }
        triggerConflictCheck();
    }

    function triggerConflictCheck() {
        const officerId = document.getElementById('officer_id').value;
        const dateVal = document.getElementById('date').value;
        const shiftVal = document.getElementById('shift').value;

        const banner = document.getElementById('live-conflict-banner');
        const conflictMsg = document.getElementById('conflict-message');
        const badge = document.getElementById('status-validation-badge');
        const icon = document.getElementById('validation-icon');
        const text = document.getElementById('validation-text');
        const tag = document.getElementById('validation-tag');

        if (!officerId || !dateVal || !shiftVal) {
            banner.classList.add('hidden');
            return;
        }

        icon.innerText = 'sync';
        icon.className = 'material-symbols-outlined text-secondary text-[20px] animate-spin';
        text.innerText = 'Memindai potensi bentrok jadwal di live system...';

        fetch('{{ route("admin.schedules.check-conflict") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                officer_id: officerId,
                date: dateVal,
                shift: shiftVal,
                exclude_id: currentScheduleId
            })
        })
        .then(res => res.json())
        .then(data => {
            icon.classList.remove('animate-spin');
            if (data.has_conflict) {
                banner.classList.remove('hidden');
                conflictMsg.innerText = data.message;

                badge.className = 'p-3.5 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between text-xs text-rose-900';
                icon.className = 'material-symbols-outlined text-rose-600 text-[20px]';
                icon.innerText = 'error';
                text.innerText = 'Peringatan: Jadwal Bentrok Terdeteksi!';
                tag.innerText = 'BENTROK TERDETEKSI';
                tag.className = 'text-[11px] font-bold text-rose-800';
            } else {
                banner.classList.add('hidden');

                badge.className = 'p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs';
                icon.className = 'material-symbols-outlined text-emerald-700 text-[20px]';
                icon.innerText = 'verified_user';
                text.innerText = 'Bebas bentrok: Personel tidak memiliki jadwal lain pada shift ini.';
                tag.innerText = 'BEBAS KONFLIK';
                tag.className = 'text-[11px] font-bold text-emerald-800';
            }
        })
        .catch(err => {
            icon.classList.remove('animate-spin');
            icon.innerText = 'verified_user';
        });
    }
</script>
@endpush

