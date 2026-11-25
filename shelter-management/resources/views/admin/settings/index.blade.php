@extends('layouts.app')

@section('title', 'Pengaturan Sistem & Profil')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Pengaturan Sistem &amp; Akun</h1>
        <p class="text-xs text-slate-500 mt-1">Konfigurasi profil administrator, keamanan kata sandi, dan informasi kontak darurat website.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left Navigation Tabs -->
        <div class="lg:col-span-4 flex flex-col gap-2">
            <button type="button" onclick="switchTab('profile', this)" class="settings-tab text-left px-4 py-3 rounded-xl bg-[#14532d] text-white font-bold text-xs flex items-center gap-2.5 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">person</span>
                <span>Profil Administrator</span>
            </button>
            <button type="button" onclick="switchTab('security', this)" class="settings-tab text-left px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs flex items-center gap-2.5 transition-all">
                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                <span>Ubah Kata Sandi</span>
            </button>
            <button type="button" onclick="switchTab('website', this)" class="settings-tab text-left px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs flex items-center gap-2.5 transition-all">
                <span class="material-symbols-outlined text-[18px]">settings_suggest</span>
                <span>Informasi Website &amp; Posko</span>
            </button>

            <!-- Account Status Card -->
            <div class="mt-4 p-4 rounded-2xl bg-white border border-slate-200 text-xs">
                <div class="flex items-center gap-2 mb-2 text-emerald-800 font-bold">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                    <span>Status Hak Akses</span>
                </div>
                <p class="text-slate-500 leading-relaxed mb-3">Akun Anda terdaftar dengan level kewenangan tertinggi sebagai Super Admin.</p>
                <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-900 font-semibold">
                    Role: {{ strtoupper(auth()->user()->role) }}<br>
                    ID Pengguna: #{{ auth()->user()->id }}
                </div>
            </div>
        </div>

        <!-- Right Tab Contents -->
        <div class="lg:col-span-8">
            <!-- TAB 1: PROFIL ADMIN -->
            <div id="tab-profile" class="tab-pane bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
                <div class="mb-5 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Profil Administrator</h2>
                        <p class="text-xs text-slate-500">Perbarui identitas profil, email, dan foto tampilan avatar.</p>
                    </div>
                    <span class="material-symbols-outlined text-emerald-700 text-2xl">account_circle</span>
                </div>

                <form action="{{ route('admin.settings.profile') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center gap-4 mb-4">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover ring-2 ring-emerald-300">
                        @else
                            <div class="w-16 h-16 rounded-full bg-[#14532d] text-white flex items-center justify-center font-bold text-xl">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <span class="text-xs font-bold text-slate-700 block mb-1">URL Avatar / Foto Profil</span>
                            <input type="url" name="avatar" value="{{ old('avatar', $user->avatar) }}" placeholder="https://..." class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Dinas</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812-..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: UBAH KATA SANDI -->
            <div id="tab-security" class="tab-pane hidden bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
                <div class="mb-5 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Keamanan Akun &amp; Kata Sandi</h2>
                        <p class="text-xs text-slate-500">Perbarui kata sandi secara berkala untuk menjaga integritas command portal.</p>
                    </div>
                    <span class="material-symbols-outlined text-emerald-700 text-2xl">lock</span>
                </div>

                <form action="{{ route('admin.settings.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" required placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="new_password" required placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="new_password_confirmation" required placeholder="Ulangi kata sandi baru" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 3: INFORMASI WEBSITE & POSKO -->
            <div id="tab-website" class="tab-pane hidden bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-emerald-900/10">
                <div class="mb-5 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Informasi Website &amp; Posko Terpadu</h2>
                        <p class="text-xs text-slate-500">Konfigurasi teks judul website, hotline darurat, frekuensi radio, dan alamat posko.</p>
                    </div>
                    <span class="material-symbols-outlined text-emerald-700 text-2xl">dns</span>
                </div>

                <form action="{{ route('admin.settings.website') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Aplikasi / Sistem</label>
                            <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tagline Sub-Judul</label>
                            <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Hotline Bebas Pulsa (24/7)</label>
                            <input type="text" name="hotline_toll_free" value="{{ old('hotline_toll_free', $settings['hotline_toll_free']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Hotline Kantor</label>
                            <input type="text" name="hotline_office" value="{{ old('hotline_office', $settings['hotline_office']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Frekuensi Radio HT Posko</label>
                            <input type="text" name="emergency_radio" value="{{ old('emergency_radio', $settings['emergency_radio']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Koordinasi</label>
                            <input type="email" name="coordination_email" value="{{ old('coordination_email', $settings['coordination_email']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Unit Koordinasi Satgas</label>
                            <input type="text" name="coordination_unit" value="{{ old('coordination_unit', $settings['coordination_unit']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Gedung Pusat Komando</label>
                        <textarea name="command_center_address" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">{{ old('command_center_address', $settings['command_center_address']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Operasional Protokol</label>
                        <input type="text" name="operational_status" value="{{ old('operational_status', $settings['operational_status']) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all">
                            Simpan Konfigurasi Website
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
        document.getElementById('tab-' + tabId).classList.remove('hidden');

        document.querySelectorAll('.settings-tab').forEach(el => {
            el.className = 'settings-tab text-left px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs flex items-center gap-2.5 transition-all';
        });

        btn.className = 'settings-tab text-left px-4 py-3 rounded-xl bg-[#14532d] text-white font-bold text-xs flex items-center gap-2.5 transition-all shadow-sm';
    }
</script>
@endsection

