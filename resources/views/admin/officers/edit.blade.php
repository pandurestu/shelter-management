@extends('layouts.app')

@section('title', 'Edit Petugas ' . $officer->name)
@section('page-title', 'Edit Petugas')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.officers.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Edit Data Personel: {{ $officer->name }}</h1>
            <p class="text-xs text-slate-500">Perbarui identitas, penempatan pos shelter, status kesiagaan, dan kontak.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
        <form action="{{ route('admin.officers.update', $officer) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Identitas (NRP / NIP) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nrp" value="{{ old('nrp', $officer->nrp) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $officer->name) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $officer->phone) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Dinas</label>
                    <input type="email" name="email" value="{{ old('email', $officer->email) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Operasional <span class="text-rose-500">*</span></label>
                    <select name="position" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        @foreach($positions as $p)
                            <option value="{{ $p }}" {{ old('position', $officer->position) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pos Shelter Penempatan</label>
                    <select name="shelter_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="">Posko Induk (Cadangan Bebas)</option>
                        @foreach($shelters as $sh)
                            <option value="{{ $sh->id }}" {{ old('shelter_id', $officer->shelter_id) == $sh->id ? 'selected' : '' }}>{{ $sh->name }} ({{ $sh->zone }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Keaktifan <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        <option value="Aktif" {{ old('status', $officer->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Siaga" {{ old('status', $officer->status) == 'Siaga' ? 'selected' : '' }}>Siaga Cadangan</option>
                        <option value="Cuti" {{ old('status', $officer->status) == 'Cuti' ? 'selected' : '' }}>Cuti Dinas</option>
                        <option value="Nonaktif" {{ old('status', $officer->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Domisili Petugas</label>
                <textarea name="address" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('address', $officer->address) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">URL Foto Profil / Dokumen ID</label>
                <input type="url" name="avatar_url" value="{{ old('avatar_url', $officer->avatar_url) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.officers.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">Perbarui Data Petugas</button>
            </div>
        </form>
    </div>
</div>
@endsection

