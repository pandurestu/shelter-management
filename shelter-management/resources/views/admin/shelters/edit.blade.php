@extends('layouts.app')

@section('title', 'Edit Pos Shelter ' . $shelter->name)
@section('page-title', 'Edit Shelter')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.shelters.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Edit Data Shelter: {{ $shelter->name }}</h1>
            <p class="text-xs text-slate-500">Perbarui informasi kapasitas, kuota penjagaan, koordinator, dan status kesiapan.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
        <form action="{{ route('admin.shelters.update', $shelter) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Shelter <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $shelter->name) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kode Unik Posko <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $shelter->code) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Zona Wilayah <span class="text-rose-500">*</span></label>
                    <select name="zone" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        @foreach($zones as $z)
                            <option value="{{ $z }}" {{ old('zone', $shelter->zone) == $z ? 'selected' : '' }}>{{ $z }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Kesiapan Operasional <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="siaga_penuh" {{ old('status', $shelter->status) == 'siaga_penuh' ? 'selected' : '' }}>Siaga Penuh</option>
                        <option value="rutin" {{ old('status', $shelter->status) == 'rutin' ? 'selected' : '' }}>Penjagaan Rutin</option>
                        <option value="perawatan" {{ old('status', $shelter->status) == 'perawatan' ? 'selected' : '' }}>Perawatan &amp; Sterilisasi</option>
                        <option value="darurat" {{ old('status', $shelter->status) == 'darurat' ? 'selected' : '' }}>Darurat &amp; Evakuasi</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat / Lokasi Perimeter <span class="text-rose-500">*</span></label>
                <textarea name="address" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('address', $shelter->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Koordinator Penanggung Jawab <span class="text-rose-500">*</span></label>
                    <input type="text" name="coordinator_name" value="{{ old('coordinator_name', $shelter->coordinator_name) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Telepon Koordinator</label>
                    <input type="text" name="coordinator_phone" value="{{ old('coordinator_phone', $shelter->coordinator_phone) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kapasitas Penghuni <span class="text-rose-500">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', $shelter->capacity) }}" min="1" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Terisi Saat Ini</label>
                    <input type="number" name="current_occupancy" value="{{ old('current_occupancy', $shelter->current_occupancy) }}" min="0" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Petugas / Shift <span class="text-rose-500">*</span></label>
                    <input type="number" name="guard_quota" value="{{ old('guard_quota', $shelter->guard_quota) }}" min="1" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Risiko Sektor <span class="text-rose-500">*</span></label>
                    <select name="risk_level" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="rendah" {{ old('risk_level', $shelter->risk_level) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ old('risk_level', $shelter->risk_level) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ old('risk_level', $shelter->risk_level) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">URL Foto Shelter</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $shelter->image_url) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi &amp; Fasilitas Khusus Posko</label>
                <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('description', $shelter->description) }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.shelters.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">Perbarui Data Shelter</button>
            </div>
        </form>
    </div>
</div>
@endsection

