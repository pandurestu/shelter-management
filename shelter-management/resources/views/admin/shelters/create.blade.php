@extends('layouts.app')

@section('title', 'Tambah Pos Shelter Baru')
@section('page-title', 'Tambah Shelter')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.shelters.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Pendaftaran Posko Shelter Baru</h1>
            <p class="text-xs text-slate-500">Isi data fasilitas, lokasi perimeter, koordinator penanggung jawab, dan kuota jaga.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
        <form action="{{ route('admin.shelters.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Shelter <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Shelter Pandu A" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kode Unik Posko <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: SH-25" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Zona Wilayah <span class="text-rose-500">*</span></label>
                    <select name="zone" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        @foreach($zones as $z)
                            <option value="{{ $z }}" {{ old('zone') == $z ? 'selected' : '' }}>{{ $z }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Kesiapan Operasional <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="siaga_penuh" {{ old('status') == 'siaga_penuh' ? 'selected' : '' }}>Siaga Penuh</option>
                        <option value="rutin" {{ old('status') == 'rutin' ? 'selected' : '' }}>Penjagaan Rutin</option>
                        <option value="perawatan" {{ old('status') == 'perawatan' ? 'selected' : '' }}>Perawatan &amp; Sterilisasi</option>
                        <option value="darurat" {{ old('status') == 'darurat' ? 'selected' : '' }}>Darurat &amp; Evakuasi</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat / Lokasi Perimeter <span class="text-rose-500">*</span></label>
                <textarea name="address" rows="2" placeholder="Contoh: Kompleks Utama Sektor Barat, Jl. Pandu No. 12" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Koordinator Penanggung Jawab <span class="text-rose-500">*</span></label>
                    <input type="text" name="coordinator_name" value="{{ old('coordinator_name') }}" placeholder="Contoh: Kapten Aris Wibowo" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Telepon Koordinator</label>
                    <input type="text" name="coordinator_phone" value="{{ old('coordinator_phone') }}" placeholder="Contoh: 0811-2233-4401" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kapasitas Penghuni <span class="text-rose-500">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', 300) }}" min="1" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Terisi Saat Ini</label>
                    <input type="number" name="current_occupancy" value="{{ old('current_occupancy', 0) }}" min="0" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Petugas / Shift <span class="text-rose-500">*</span></label>
                    <input type="number" name="guard_quota" value="{{ old('guard_quota', 6) }}" min="1" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Risiko Sektor <span class="text-rose-500">*</span></label>
                    <select name="risk_level" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="rendah" {{ old('risk_level') == 'rendah' ? 'selected' : '' }}>Rendah (Herbivora / Fasilitas Umum)</option>
                        <option value="sedang" {{ old('risk_level', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang (Reptilia / Kubah Terbang)</option>
                        <option value="tinggi" {{ old('risk_level') == 'tinggi' ? 'selected' : '' }}>Tinggi (Karnivora Besar / Mamalia Berat)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">URL Foto Shelter (Opsional)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi &amp; Fasilitas Khusus Posko</label>
                <textarea name="description" rows="3" placeholder="Tuliskan spesifikasi pagar pembatas, instalasi air, sensor gerak, atau catatan khusus posko..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.shelters.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">Simpan Pos Shelter</button>
            </div>
        </form>
    </div>
</div>
@endsection

