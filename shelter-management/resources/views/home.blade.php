<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_standard" name="shell-type"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shelter Management System - Taman Safari Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #c0c9be; border-radius: 9999px; }
    </style>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-fixed": "#b1f2be",
                        "secondary-container": "#92f5a4",
                        "tertiary-fixed": "#c1edc8",
                        "secondary": "#15803d",
                        "on-surface": "#111914",
                        "surface": "#f7fbf8",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f0f7f2",
                        "brand-forest": "#14532d",
                        "surface-container": "#e6f2e9",
                        "brand-emerald-action": "#15803d",
                        "brand-emerald-border": "#bbf7d0",
                        "surface-container-lowest": "#ffffff",
                        "brand-deep-header": "#052e16",
                        "primary-container": "#14532d",
                        "brand-emerald-subtle": "#f0fdf4",
                        "primary": "#14532d",
                        "brand-emerald-hover": "#166534",
                        "surface-border": "#e2e8e5",
                        "error": "#ba1a1a"
                    },
                    spacing: {
                        "space-xl": "2rem",
                        "space-md": "1rem",
                        "gutter": "1.5rem",
                        "margin": "2rem",
                        "space-lg": "1.5rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem"
                    },
                    fontFamily: {
                        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-xl": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "label-lg": ["Inter", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased">

<!-- NAVBAR -->
<header class="fixed top-0 w-full z-50 bg-[#f7fbf8]/95 backdrop-blur-xl border-b border-[#e6f2e9] shadow-[0_1px_8px_rgba(20,83,45,0.06)]">
    <div class="h-20 w-full px-4 lg:px-8 flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-decoration-none group">
            <img src="{{ asset('images/logo.png') }}" alt="Taman Safari Bogor Logo" class="h-12 w-auto object-contain group-hover:scale-105 transition-transform">
            <div class="flex flex-col">
                <span class="font-bold text-base lg:text-lg text-[#111914] uppercase tracking-tight font-['Plus_Jakarta_Sans'] leading-tight">{{ $settings['site_name'] }}</span>
                <span class="text-[10px] lg:text-[11px] text-emerald-800 font-bold uppercase tracking-wider mt-0.5">PENJAGAAN SATWA &amp; BENCANA TERPADU</span>
            </div>
        </a>

        <nav class="hidden lg:flex items-center gap-6">
            <a href="{{ route('home') }}" class="text-secondary font-bold text-sm transition-colors">Home</a>
            <a href="#daftar-shelter" class="text-slate-600 hover:text-secondary text-sm font-semibold transition-colors">Daftar Shelter</a>
            <a href="#jadwal-penjagaan" class="text-slate-600 hover:text-secondary text-sm font-semibold transition-colors">Jadwal Penjagaan</a>
            <a href="#cara-kerja" class="text-slate-600 hover:text-secondary text-sm font-semibold transition-colors">Cara Kerja</a>
            <a href="#tentang-kami" class="text-slate-600 hover:text-secondary text-sm font-semibold transition-colors">Tentang Kami</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold shadow-md hover:bg-[#166534] transition-all">
                    <span>Ke Dashboard Admin</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold shadow-md transition-all hover:scale-[1.02]">
                    Login
                </a>
            @endauth
        </div>
    </div>
</header>

<main class="w-full pt-20 bg-surface">
    <div class="flex flex-col w-full">
        <!-- HERO SECTION -->
        <section class="w-full px-4 lg:px-8 py-16 lg:py-24 relative overflow-hidden bg-gradient-to-b from-[#f0fdf4] via-[#f0f7f2] to-[#f7fbf8]">
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-emerald-200/40 blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 right-0 w-[30rem] h-[30rem] rounded-full bg-green-100/50 blur-3xl pointer-events-none"></div>

            <div class="w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <!-- Hero Copy -->
                <div class="lg:col-span-6 flex flex-col gap-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-xs w-fit shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span class="tracking-wide uppercase">{{ $settings['coordination_unit'] }}</span>
                    </div>

                    <h1 class="font-['Plus_Jakarta_Sans'] text-3xl lg:text-5xl font-extrabold text-[#111914] tracking-tight leading-tight">
                        Sistem Informasi <br/>
                        <span class="text-[#16a34a]">Jadwal Plotting</span> Shelter
                    </h1>

                    <p class="text-base text-slate-600 max-w-xl leading-relaxed">
                        Kelola informasi pos shelter, pantau jadwal penjagaan shift secara realtime, dan lihat pembagian personel jaga dalam satu platform terintegrasi, transparan, dan bebas bentrok.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="#jadwal-penjagaan" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#14532d] text-white font-bold text-sm shadow-md hover:bg-[#166534] transition-all hover:scale-[1.02]">
                            <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                            <span>Lihat Jadwal Shelter</span>
                        </a>
                        <a href="#daftar-shelter" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white border border-emerald-300 text-emerald-900 font-bold text-sm shadow-sm hover:bg-emerald-50 transition-all">
                            <span class="material-symbols-outlined text-[20px]">apartment</span>
                            <span>Eksplorasi {{ $totalShelters }} Shelter</span>
                        </a>
                    </div>

                    <!-- Metric Badges Row -->
                    <div class="grid grid-cols-3 gap-3 pt-4">
                        <div class="p-3 rounded-xl bg-white border border-emerald-200 shadow-sm flex flex-col">
                            <span class="text-xl font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">100%</span>
                            <span class="text-xs text-slate-500 font-medium">Posko Tercover</span>
                        </div>
                        <div class="p-3 rounded-xl bg-white border border-emerald-200 shadow-sm flex flex-col">
                            <span class="text-xl font-extrabold text-emerald-700 font-['Plus_Jakarta_Sans']">24 Jam</span>
                            <span class="text-xs text-slate-500 font-medium">3 Shift Siaga</span>
                        </div>
                        <div class="p-3 rounded-xl bg-white border border-emerald-200 shadow-sm flex flex-col">
                            <span class="text-xl font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">&lt; 1 Detik</span>
                            <span class="text-xs text-slate-500 font-medium">Sinkron Live System</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Visual (Foto Lanskap Taman Safari Bogor) -->
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-white border border-emerald-200 group">
                        <img alt="Kawasan Konservasi Taman Safari Bogor" class="w-full h-80 lg:h-96 object-cover transform transition-transform duration-700 group-hover:scale-105" src="{{ asset('images/taman-safari-aerial.jpg') }}"/>
                        <div class="absolute bottom-4 right-4 bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-xl shadow-lg flex items-center gap-3 border border-emerald-200">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-800">
                                <span class="material-symbols-outlined text-[20px]">nature_people</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[11px] text-slate-500 font-medium">Kawasan Konservasi &amp; Pos Jaga</span>
                                <span class="text-xs font-bold text-slate-900">{{ $totalShelters }} Unit Shelter Terpantau</span>
                            </div>
                        </div>
                        <div class="absolute top-4 left-4 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-xl shadow-md flex items-center gap-2 border border-white/20 text-white">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[11px] font-bold tracking-wide uppercase">Taman Safari Bogor</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kawasan Konservasi & Status Operasional Strip -->
            <div class="w-full max-w-7xl mx-auto mt-8 p-4 rounded-2xl bg-white border border-emerald-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-800 shrink-0">
                        <span class="material-symbols-outlined text-[22px]">pets</span>
                    </div>
                    <div>
                        <span class="text-[11px] text-emerald-800 font-bold uppercase tracking-wider block">Kawasan Konservasi &amp; Penjagaan</span>
                        <span class="text-sm font-extrabold text-slate-900 font-['Plus_Jakarta_Sans']">Taman Safari Indonesia Bogor • Siaga 24 Jam</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-6 text-xs text-slate-600 font-semibold">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span class="material-symbols-outlined text-[18px] text-emerald-700">emergency_home</span>
                        <span>{{ $totalShelters }} Titik Shelter Terpantau</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-emerald-700">security</span>
                        <span>Satgas Penjagaan Wilayah (3 Shift)</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-emerald-700">shield_with_heart</span>
                        <span>Penjagaan Satwa &amp; Mitigasi Terpadu</span>
                    </span>
                </div>
            </div>
        </section>

        <!-- SECTION 2: STATISTIK REAL LIVE SYSTEM -->
        <section class="w-full px-4 lg:px-8 py-12 bg-surface">
            <div class="w-full max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
                    <div>
                        <span class="text-xs text-emerald-700 uppercase font-bold tracking-wider">Telemetri &amp; Inventaris Pos</span>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-2xl lg:text-3xl font-bold text-slate-900 mt-1">Statistik Shelter &amp; Penugasan</h2>
                    </div>
                    <p class="text-xs text-slate-500 max-w-md mt-2 md:mt-0">
                        Metrik operasional realtime yang dihimpun dari live system posko logistik, posko pemantauan, dan jadwal shift jaga.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Shelter -->
                    <div class="p-6 rounded-2xl bg-white border border-emerald-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800">
                                <span class="material-symbols-outlined text-[28px]">domain</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">Terdaftar</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Total Shelter</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900">{{ $totalShelters }}</span>
                                <span class="text-sm font-semibold text-slate-500">Unit Pos</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Kapasitas 100% terdata dalam sistem</p>
                        </div>
                        <div class="w-full bg-emerald-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-[#14532d] h-full rounded-full" style="width: 100%;"></div>
                        </div>
                    </div>

                    <!-- Total Petugas -->
                    <div class="p-6 rounded-2xl bg-white border border-emerald-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800">
                                <span class="material-symbols-outlined text-[28px]">badge</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">Personel Siaga</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Total Petugas</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900">{{ $totalOfficers }}</span>
                                <span class="text-sm font-semibold text-slate-500">Personel</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Ranger, Medis Satwa &amp; Patroli Pos</p>
                        </div>
                        <div class="w-full bg-emerald-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-[#14532d] h-full rounded-full" style="width: 95%;"></div>
                        </div>
                    </div>

                    <!-- Jadwal Hari Ini -->
                    <div class="p-6 rounded-2xl bg-white border border-emerald-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800">
                                <span class="material-symbols-outlined text-[28px]">schedule</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">Hari Ini</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Jadwal Hari Ini</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900">{{ $todaySchedulesCount }}</span>
                                <span class="text-sm font-semibold text-slate-500">Sesi Jaga</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Shift Pagi, Siang, &amp; Malam aktif</p>
                        </div>
                        <div class="w-full bg-emerald-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-[#14532d] h-full rounded-full" style="width: 80%;"></div>
                        </div>
                    </div>

                    <!-- Total Jadwal Aktif -->
                    <div class="p-6 rounded-2xl bg-white border border-emerald-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800">
                                <span class="material-symbols-outlined text-[28px]">assignment_turned_in</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">Terplotting</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Total Jadwal Aktif</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900">{{ $totalActiveSchedules }}</span>
                                <span class="text-sm font-semibold text-slate-500">Plotting</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Tercatat dalam kalender rotasi</p>
                        </div>
                        <div class="w-full bg-emerald-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-[#14532d] h-full rounded-full" style="width: 90%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: DAFTAR SHELTER TERPANTAU -->
        <section class="w-full px-4 lg:px-8 py-16 bg-[#f0f7f2]" id="daftar-shelter">
            <div class="w-full max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8">
                    <div>
                        <span class="text-xs text-emerald-700 uppercase font-bold tracking-wider">Direktori Fasilitas Posko</span>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-2xl lg:text-3xl font-bold text-slate-900 mt-1">Daftar Shelter Terpantau</h2>
                        <p class="text-sm text-slate-600 mt-1 max-w-xl">
                            Monitoring kondisi operasional {{ $totalShelters }} posko shelter, daya tampung, perwira koordinator, dan regu jaga aktif.
                        </p>
                    </div>

                    <!-- Search & Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400">search</span>
                            <input type="text" id="shelterSearchInput" onkeyup="searchShelterCards()" placeholder="Cari nama posko / kode..." class="pl-9 pr-3 py-2 rounded-xl bg-white text-slate-900 text-xs border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-600 w-52 transition-all shadow-sm">
                        </div>
                        <div class="inline-flex p-1 rounded-xl bg-[#e6f2e9] text-slate-600 text-xs border border-emerald-200 overflow-x-auto max-w-full" id="shelterFilterTabs">
                            <button type="button" class="filter-tab px-3.5 py-2 rounded-lg bg-[#14532d] text-white font-bold shadow-sm transition-all whitespace-nowrap" onclick="filterShelters('all', this)">Semua ({{ $totalShelters }})</button>
                            <button type="button" class="filter-tab px-3.5 py-2 rounded-lg hover:text-secondary font-semibold transition-all whitespace-nowrap" onclick="filterShelters('Zona Utara', this)">Zona Utara</button>
                            <button type="button" class="filter-tab px-3.5 py-2 rounded-lg hover:text-secondary font-semibold transition-all whitespace-nowrap" onclick="filterShelters('Zona Selatan', this)">Zona Selatan</button>
                            <button type="button" class="filter-tab px-3.5 py-2 rounded-lg hover:text-secondary font-semibold transition-all whitespace-nowrap" onclick="filterShelters('Zona Barat', this)">Zona Barat</button>
                            <button type="button" class="filter-tab px-3.5 py-2 rounded-lg hover:text-secondary font-semibold transition-all whitespace-nowrap" onclick="filterShelters('Zona Timur', this)">Zona Timur</button>
                            <button type="button" class="filter-tab px-3.5 py-2 rounded-lg hover:text-secondary font-semibold transition-all whitespace-nowrap" onclick="filterShelters('siaga_penuh', this)">Siaga Penuh</button>
                        </div>
                    </div>
                </div>

                <!-- Shelter Cards Grid (Semua 24 Posko Terdaftar) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="shelterGrid">
                    @foreach($shelters as $index => $sh)
                        <div class="shelter-card flex flex-col justify-between rounded-2xl bg-white border border-emerald-200 shadow-sm hover:shadow-md transition-all group overflow-hidden {{ $index >= 8 ? 'shelter-extra hidden' : '' }}" data-status="{{ $sh->status }}" data-zone="{{ $sh->zone }}" data-index="{{ $index }}">
                            <div class="relative">
                                @if($sh->image_url)
                                    <img alt="{{ $sh->name }}" class="w-full h-44 object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-500" src="{{ $sh->image_url }}"/>
                                @else
                                    <div class="w-full h-44 bg-gradient-to-br from-[#0a2316] to-[#14532d] flex items-center justify-center text-emerald-300">
                                        <span class="material-symbols-outlined text-[48px]">domain</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-md text-slate-800 font-bold text-xs shadow-sm">Kode: {{ $sh->code }}</span>
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-md text-emerald-800 font-bold text-xs shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        {{ ucfirst(str_replace('_', ' ', $sh->status)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1">
                                <div>
                                    <div class="flex items-center justify-between text-xs text-emerald-800 font-bold mb-1">
                                        <span>{{ $sh->zone }}</span>
                                        <span class="text-slate-400">Risiko: {{ ucfirst($sh->risk_level) }}</span>
                                    </div>
                                    <h3 class="font-bold text-base text-slate-900 group-hover:text-emerald-700 transition-colors font-['Plus_Jakarta_Sans']">{{ $sh->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 flex items-start gap-1 line-clamp-2">
                                        <span class="material-symbols-outlined text-[16px] text-emerald-600 shrink-0">location_on</span>
                                        {{ $sh->address }}
                                    </p>
                                    <div class="mt-4 pt-3 border-t border-slate-100 flex flex-col gap-1.5 text-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-500">Koordinator:</span>
                                            <span class="text-slate-900 font-semibold">{{ $sh->coordinator_name ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-500">Petugas Terdaftar:</span>
                                            <span class="text-emerald-700 font-bold">{{ $sh->officers_count }} Personel</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-500">Kapasitas:</span>
                                            <span class="text-slate-900">{{ $sh->current_occupancy }} / {{ $sh->capacity }} Jiwa</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="mt-4 w-full py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] transition-colors flex items-center justify-center gap-1.5 shadow-sm" onclick="openShelterModal('{{ addslashes($sh->name) }}', '{{ addslashes($sh->address) }}', '{{ addslashes($sh->coordinator_name) }}', '{{ $sh->officers_count }} Personel Aktif', '{{ ucfirst(str_replace('_', ' ', $sh->status)) }}', '{{ $sh->current_occupancy }} / {{ $sh->capacity }} Jiwa', '{{ addslashes($sh->description) }}')">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span>Lihat Detail Pos</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer Action & Direktori Lengkap 24 Posko Trigger -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 p-5 rounded-2xl bg-emerald-50 border border-emerald-200">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span id="shelterCountSummary" class="text-sm text-slate-800 font-bold">
                            Menampilkan 8 dari {{ $totalShelters }} Shelter Terdaftar
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" id="btnToggleAllShelters" onclick="toggleAllShelters()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold shadow-md hover:bg-[#166534] transition-all hover:scale-[1.02] cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]" id="toggleShelterIcon">grid_view</span>
                            <span id="toggleShelterLabel">Akses Direktori Lengkap ({{ $totalShelters }} Posko)</span>
                            <span class="material-symbols-outlined text-[16px]" id="toggleShelterArrow">arrow_forward</span>
                        </button>
                        @auth
                            <a href="{{ route('admin.shelters.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white border border-emerald-300 text-emerald-900 text-xs font-bold shadow-sm hover:bg-emerald-100/50 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                                <span>Kelola di Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white border border-emerald-300 text-emerald-900 text-xs font-bold shadow-sm hover:bg-emerald-100/50 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">login</span>
                                <span>Login Petugas Posko</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: JADWAL PENJAGAAN TERBARU (TABEL LIVE SYSTEM) -->
        <section class="w-full px-4 lg:px-8 py-16 bg-surface" id="jadwal-penjagaan">
            <div class="w-full max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8">
                    <div>
                        <span class="text-xs text-emerald-700 uppercase font-bold tracking-wider">Plotting Rotasi Jaga</span>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-2xl lg:text-3xl font-bold text-slate-900 mt-1">Jadwal Penjagaan Hari Ini &amp; Mendatang</h2>
                        <p class="text-sm text-slate-600 mt-1 max-w-2xl">
                            Tabel plotting dinamis petugas di setiap pos jaga. Data disinkronkan otomatis sesuai live system verifikasi tugas dan absen.
                        </p>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400">search</span>
                            <input type="text" id="scheduleSearchInput" onkeyup="searchScheduleTable()" placeholder="Cari shelter / nama petugas..." class="pl-9 pr-4 py-2 rounded-xl bg-slate-100 text-slate-900 text-xs focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-600 border border-slate-200 w-64 transition-all"/>
                        </div>
                        <select id="shiftFilterSelect" onchange="filterScheduleByShift(this.value)" class="py-2 px-3 rounded-xl bg-slate-100 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 border border-slate-200">
                            <option value="all">Semua Shift</option>
                            <option value="Pagi">Shift 1 - Pagi (07:00 - 15:00)</option>
                            <option value="Siang">Shift 2 - Siang (15:00 - 23:00)</option>
                            <option value="Malam">Shift 3 - Malam (23:00 - 07:00)</option>
                        </select>
                    </div>
                </div>

                <!-- Schedule Table Container -->
                <div class="w-full overflow-hidden rounded-2xl bg-white border border-emerald-200 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="scheduleTable">
                            <thead class="bg-emerald-50 text-slate-900 text-xs font-bold uppercase tracking-wider border-b border-emerald-200">
                                <tr>
                                    <th class="py-4 px-4">Nama Shelter</th>
                                    <th class="py-4 px-4">Nama Petugas</th>
                                    <th class="py-4 px-4">Hari &amp; Tanggal</th>
                                    <th class="py-4 px-4">Jam Penjagaan</th>
                                    <th class="py-4 px-4">Shift</th>
                                    <th class="py-4 px-4">Status</th>
                                    <th class="py-4 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @forelse($schedules as $sched)
                                    <tr class="schedule-row hover:bg-emerald-50/50 transition-colors" data-shift="{{ $sched->shift }}">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                                <span class="font-bold text-slate-900">{{ $sched->shelter?->name ?? 'Posko Induk' }}</span>
                                            </div>
                                            <span class="text-xs text-slate-400 block pl-4">{{ $sched->shelter?->zone ?? '-' }}</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                @if($sched->officer?->avatar_url)
                                                    <img class="w-8 h-8 rounded-full object-cover shrink-0 ring-1 ring-emerald-300" src="{{ $sched->officer->avatar_url }}" alt="{{ $sched->officer->name }}">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-[#14532d] text-white font-bold text-xs flex items-center justify-center shrink-0">
                                                        {{ substr($sched->officer?->name ?? 'P', 0, 2) }}
                                                    </div>
                                                @endif
                                                <div class="flex flex-col">
                                                    <span class="font-semibold text-slate-900 text-xs">{{ $sched->officer?->name ?? 'Petugas Regu' }}</span>
                                                    <span class="text-[11px] text-slate-500">NRP: {{ $sched->officer?->nrp ?? '-' }} • {{ $sched->officer?->position ?? 'Petugas' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-600">
                                            <span class="font-medium text-slate-900 block">{{ $sched->day }}, {{ $sched->date->format('d M Y') }}</span>
                                            @if($sched->date->isToday())
                                                <span class="text-[10px] text-emerald-700 font-bold uppercase tracking-wider">● Hari Ini</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-xs font-semibold text-slate-900">
                                            {{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }} WIB
                                        </td>
                                        <td class="py-3.5 px-4 text-xs">
                                            <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-semibold">
                                                Shift {{ $sched->shift }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs">
                                            @if($sched->status === 'Sedang Bertugas')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                                    Sedang Bertugas
                                                </span>
                                            @elseif($sched->status === 'Siaga Shift')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 font-bold text-xs border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    Siaga Shift
                                                </span>
                                            @elseif($sched->status === 'Selesai Shift')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 font-medium text-xs">
                                                    Selesai Shift
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-medium text-xs">
                                                    {{ $sched->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button type="button" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#14532d] hover:text-white text-emerald-800 text-xs font-bold transition-colors" onclick="previewDuty('{{ addslashes($sched->shelter?->name ?? 'Posko Induk') }}', '{{ addslashes($sched->officer?->name ?? 'Petugas') }}', 'Shift {{ $sched->shift }}', '{{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }} WIB', '{{ $sched->status }}', '{{ addslashes($sched->notes ?? 'Piket rutin penjagaan & patroli posko.') }}')">
                                                Detail Tugas
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-slate-400 text-sm">Tidak ada jadwal penjagaan yang tersedia saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Footer -->
                    <div class="p-4 bg-emerald-50/70 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-emerald-200">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.reports.print') }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-emerald-200 text-slate-800 text-xs font-bold hover:bg-emerald-50 transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-rose-600">picture_as_pdf</span>
                                <span>Cetak Rekap Jadwal</span>
                            </a>
                            <a href="{{ route('admin.reports.export-excel') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-emerald-200 text-slate-800 text-xs font-bold hover:bg-emerald-50 transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-emerald-700">table_view</span>
                                <span>Unduh Spreadsheet Excel</span>
                            </a>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] transition-colors shadow-sm">
                            <span>Kelola Jadwal di Admin Dashboard</span>
                            <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 5: CARA KERJA SISTEM -->
        <section class="w-full px-4 lg:px-8 py-16 bg-[#f0f7f2]" id="cara-kerja">
            <div class="w-full max-w-7xl mx-auto">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs text-emerald-700 uppercase font-bold tracking-wider">Alur Operasional Sederhana</span>
                    <h2 class="font-['Plus_Jakarta_Sans'] text-2xl lg:text-3xl font-bold text-slate-900 mt-1">Cara Kerja Sistem Informasi Plotting</h2>
                    <p class="text-sm text-slate-600 mt-2">
                        Tiga langkah praktis mengakses jadwal dan plotting penjagaan di seluruh posko shelter terdaftar tanpa birokrasi manual.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Step 1 -->
                    <div class="p-7 rounded-2xl bg-white border border-emerald-200/90 shadow-sm relative flex flex-col justify-between group hover:shadow-xl hover:border-emerald-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-[#14532d] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                                        <span class="material-symbols-outlined text-[26px]">apartment</span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-[#14532d] text-xs font-black font-mono tracking-wider">LANGKAH 01</span>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">10 Pos Siaga</span>
                            </div>
                            <h3 class="font-['Plus_Jakarta_Sans'] text-lg font-bold text-slate-900 mb-2">Pilih Shelter</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Cari dan tentukan unit shelter berdasarkan zona wilayah (Utara, Selatan, Barat, Timur), estimasi kapasitas, ketersediaan daya dukung medis, atau kode unik posko darurat.
                            </p>
                        </div>
                        <a href="#daftar-shelter" onclick="highlightShelterSearch()" class="mt-6 p-3 rounded-xl bg-emerald-50 hover:bg-[#14532d] hover:text-white text-emerald-800 text-xs font-bold flex items-center justify-between border border-emerald-200 transition-all group/btn shadow-sm">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                                <span>Filter Cepat Zona &amp; Kode</span>
                            </span>
                            <span class="material-symbols-outlined text-[18px] group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-7 rounded-2xl bg-white border border-emerald-200/90 shadow-sm relative flex flex-col justify-between group hover:shadow-xl hover:border-emerald-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-[#14532d] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                                        <span class="material-symbols-outlined text-[26px]">event_repeat</span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-[#14532d] text-xs font-black font-mono tracking-wider">LANGKAH 02</span>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">3 Shift 24 Jam</span>
                            </div>
                            <h3 class="font-['Plus_Jakarta_Sans'] text-lg font-bold text-slate-900 mb-2">Lihat Jadwal Penjagaan</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Periksa kalender shift penjagaan real-time, rotasi waktu tugas 3-shift berkala (Pagi 07:00-15:00, Siang 15:00-23:00, Malam 23:00-07:00), serta status serah terima antar regu.
                            </p>
                        </div>
                        <a href="#jadwal-penjagaan" class="mt-6 p-3 rounded-xl bg-emerald-50 hover:bg-[#14532d] hover:text-white text-emerald-800 text-xs font-bold flex items-center justify-between border border-emerald-200 transition-all group/btn shadow-sm">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">schedule</span>
                                <span>Rotasi 8 Jam Otomatis</span>
                            </span>
                            <span class="material-symbols-outlined text-[18px] group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-7 rounded-2xl bg-white border border-emerald-200/90 shadow-sm relative flex flex-col justify-between group hover:shadow-xl hover:border-emerald-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-[#14532d] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                                        <span class="material-symbols-outlined text-[26px]">verified_user</span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-[#14532d] text-xs font-black font-mono tracking-wider">LANGKAH 03</span>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">Bebas Bentrok</span>
                            </div>
                            <h3 class="font-['Plus_Jakarta_Sans'] text-lg font-bold text-slate-900 mb-2">Pantau Petugas Aktif</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Ketahui koordinator lapangan yang sedang memimpin, nama personel jaga aktif, kontak darurat satgas, dan validasi bentrok jadwal secara presisi.
                            </p>
                        </div>
                        <a href="#jadwal-penjagaan" onclick="focusScheduleSearch()" class="mt-6 p-3 rounded-xl bg-emerald-50 hover:bg-[#14532d] hover:text-white text-emerald-800 text-xs font-bold flex items-center justify-between border border-emerald-200 transition-all group/btn shadow-sm">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">badge</span>
                                <span>Integrasi ID &amp; Kontak Lapangan</span>
                            </span>
                            <span class="material-symbols-outlined text-[18px] group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 6: TENTANG KAMI & HOTLINE DARURAT -->
        <section class="w-full px-4 lg:px-8 py-16 bg-surface" id="tentang-kami">
            <div class="w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 flex flex-col gap-4">
                    <span class="text-xs text-emerald-700 uppercase font-bold tracking-wider">Tentang Otoritas Sistem</span>
                    <h2 class="font-['Plus_Jakarta_Sans'] text-2xl lg:text-3xl font-bold text-slate-900">Pusat Komando &amp; Perlindungan Posko Terpadu</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Sistem Informasi Shelter Management dirancang guna menjawab tantangan ketepatan alokasi personel penjaga, kesiapsiagaan tanggap darurat, dan keterbukaan informasi publik bagi masyarakat serta instansi terkait.
                    </p>
                    <div class="flex flex-col gap-3 pt-2">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center text-emerald-700 shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div>
                                <h4 class="font-['Plus_Jakarta_Sans'] text-sm font-bold text-slate-900">Standar Pengamanan 24/7</h4>
                                <p class="text-xs text-slate-500">Setiap shelter diproteksi minimal 2 regu patroli bersertifikasi penanganan khusus satwa &amp; evakuasi.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center text-emerald-700 shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div>
                                <h4 class="font-['Plus_Jakarta_Sans'] text-sm font-bold text-slate-900">Audit &amp; Deteksi Bentrok Presisi</h4>
                                <p class="text-xs text-slate-500">Plotting shift diproteksi algoritma anti tumpang tindih waktu untuk mencegah dobel penugasan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Box -->
                <div class="lg:col-span-6 p-8 rounded-3xl bg-gradient-to-br from-[#0a2e1d] to-[#14532d] text-white shadow-xl relative overflow-hidden border border-emerald-800">
                    <div class="absolute -right-10 -bottom-10 w-60 h-60 rounded-full bg-emerald-500/20 blur-2xl pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-white/10 text-emerald-300 text-xs uppercase font-bold">Hotline Kedaruratan</span>
                            <span class="material-symbols-outlined text-[24px] text-emerald-300">emergency</span>
                        </div>
                        <h3 class="font-['Plus_Jakarta_Sans'] text-xl font-bold text-white">{{ $settings['command_center_address'] }}</h3>
                        <p class="text-xs text-emerald-100/90 leading-relaxed">
                            Hubungi kanal prioritas di bawah ini untuk melaporkan situasi darurat pada pos shelter, permohonan pergantian shift darurat, atau suplai logistik keamanan.
                        </p>
                        <div class="p-4 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-emerald-200 block">Hotline Siaga Bebas Pulsa</span>
                                <span class="text-2xl font-extrabold text-white font-['Plus_Jakarta_Sans']">{{ $settings['hotline_toll_free'] }}</span>
                            </div>
                            <a href="tel:{{ str_replace([' ', '-'], '', $settings['hotline_toll_free']) }}" class="px-4 py-2 rounded-xl bg-[#92f5a4] text-[#003b1b] text-xs font-bold hover:brightness-105 transition-all shadow-sm">Panggil Cepat</a>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-xs text-emerald-100 pt-1">
                            <div>
                                <span class="font-semibold text-white block">Frekuensi Radio HT:</span>
                                <span>{{ $settings['emergency_radio'] }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-white block">Unit Koordinasi:</span>
                                <span>{{ $settings['coordination_unit'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="w-full bg-[#052e16] text-white py-12 border-t border-[#143d26]">
            <div class="w-full max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div class="md:col-span-2 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-white px-3 py-2 rounded-2xl shadow-md inline-flex items-center justify-center shrink-0 border border-emerald-100">
                                <img src="{{ asset('images/logo.png') }}" alt="Taman Safari Bogor Logo" class="h-11 w-auto object-contain">
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-base text-white font-['Plus_Jakarta_Sans'] leading-tight">{{ $settings['site_name'] }}</span>
                                <span class="text-xs text-emerald-300 font-bold uppercase tracking-wider mt-0.5">PENJAGAAN SATWA &amp; BENCANA TERPADU</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                            Platform infrastruktur terpadu koordinasi tanggap darurat, monitoring shelter, plotting personel jaga, serta deteksi bebas bentrok rotasi shift secara realtime dan transparan.
                        </p>
                        <div class="pt-1">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950 text-emerald-300 border border-emerald-800 text-xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                Status Sistem: Operasional Normal (Real-time)
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs text-white uppercase tracking-wider block font-bold mb-3">Navigasi Cepat</span>
                        <ul class="flex flex-col gap-2 text-xs text-slate-300">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 transition-colors">Dashboard Monitoring</a></li>
                            <li><a href="#daftar-shelter" class="hover:text-emerald-400 transition-colors">Daftar Shelter Aktif</a></li>
                            <li><a href="#jadwal-penjagaan" class="hover:text-emerald-400 transition-colors">Plotting Jadwal Shift</a></li>
                            <li><a href="#cara-kerja" class="hover:text-emerald-400 transition-colors">Cara Kerja Sistem</a></li>
                            <li><a href="#tentang-kami" class="hover:text-emerald-400 transition-colors">Tentang Komando</a></li>
                        </ul>
                    </div>

                    <div>
                        <span class="text-xs text-white uppercase tracking-wider block font-bold mb-3">Kontak Posko</span>
                        <ul class="flex flex-col gap-2 text-xs text-slate-300">
                            <li><span class="text-slate-400 block">Call Center:</span>{{ $settings['hotline_toll_free'] }}</li>
                            <li><span class="text-slate-400 block">Hotline Kantor:</span>{{ $settings['hotline_office'] }}</li>
                            <li><span class="text-slate-400 block">Email Koordinasi:</span>{{ $settings['coordination_email'] }}</li>
                        </ul>
                    </div>
                </div>

                <div class="pt-6 flex flex-col items-center justify-center text-center gap-2 text-xs text-slate-400 border-t border-[#143d26]">
                    <p>&copy; {{ date('Y') }} Shelter Management System. Seluruh hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>
</main>

<!-- MODAL: DETAIL SHELTER -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-200" id="shelterDetailModal">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl flex flex-col gap-4 border border-emerald-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                <span class="text-xs uppercase font-bold text-emerald-800 tracking-wider">Detail Posko Shelter</span>
            </div>
            <button class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors" onclick="closeModal('shelterDetailModal')">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
        <div>
            <h3 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']" id="modalShelterName">Nama Shelter</h3>
            <p class="text-xs text-slate-500 mt-1" id="modalShelterLoc">Alamat Lokasi Shelter</p>
        </div>
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex flex-col gap-2.5 text-xs">
            <div class="flex justify-between items-center">
                <span class="text-slate-600">Koordinator Penanggung Jawab:</span>
                <span class="font-bold text-slate-900" id="modalShelterCoord">-</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-600">Personel Aktif:</span>
                <span class="font-bold text-emerald-700" id="modalShelterGuards">-</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-600">Kapasitas Penghuni Terdata:</span>
                <span class="font-medium text-slate-900" id="modalShelterCap">-</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-600">Status Siaga:</span>
                <span class="font-bold text-emerald-800" id="modalShelterStatus">-</span>
            </div>
            <div class="pt-2 border-t border-emerald-200/60 text-slate-600" id="modalShelterDesc">
                -
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="button" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors" onclick="closeModal('shelterDetailModal')">
                Tutup
            </button>
            <button type="button" class="px-4 py-2 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] transition-colors shadow-sm" onclick="jumpToScheduleAndClose()">
                Lihat Jadwal Terkait
            </button>
        </div>
    </div>
</div>

<!-- MODAL: PREVIEW DETAIL TUGAS -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-200" id="dutyPreviewModal">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl flex flex-col gap-4 border border-emerald-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1.5 text-emerald-800 text-xs uppercase font-bold tracking-wider">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                <span>Perintah Penugasan Shift</span>
            </div>
            <button class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors" onclick="closeModal('dutyPreviewModal')">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-[11px] text-slate-500 font-medium">Unit Posko Penjagaan</span>
            <h3 class="text-lg font-bold text-slate-900 font-['Plus_Jakarta_Sans']" id="dutyShelter">Nama Shelter</h3>
        </div>
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex flex-col gap-2 text-xs">
            <div class="flex justify-between py-1 border-b border-emerald-200/50">
                <span class="text-slate-500">Petugas / Regu:</span>
                <span class="font-bold text-slate-900 text-right" id="dutyOfficer">-</span>
            </div>
            <div class="flex justify-between py-1 border-b border-emerald-200/50">
                <span class="text-slate-500">Shift Kerja:</span>
                <span class="font-semibold text-emerald-800" id="dutyShift">-</span>
            </div>
            <div class="flex justify-between py-1 border-b border-emerald-200/50">
                <span class="text-slate-500">Waktu Tugas:</span>
                <span class="font-semibold text-slate-900" id="dutyTime">-</span>
            </div>
            <div class="flex justify-between py-1 border-b border-emerald-200/50">
                <span class="text-slate-500">Status Tugas:</span>
                <span class="font-bold text-emerald-700" id="dutyStatus">-</span>
            </div>
            <div class="py-1">
                <span class="text-slate-500 block mb-0.5">Catatan Operasional:</span>
                <span class="font-normal text-slate-700 italic" id="dutyNotes">-</span>
            </div>
        </div>
        <p class="text-xs text-slate-500">
            Catatan: Petugas wajib standby 15 menit sebelum pergantian shift dan melakukan serah terima inventaris posko.
        </p>
        <button type="button" class="w-full py-2.5 rounded-xl bg-[#14532d] text-white text-xs font-bold hover:bg-[#166534] transition-colors shadow-sm" onclick="closeModal('dutyPreviewModal')">
            Tutup Pratinjau
        </button>
    </div>
</div>

<script>
    function openShelterModal(name, loc, coord, guards, status, cap, desc = '') {
        document.getElementById('modalShelterName').innerText = name;
        document.getElementById('modalShelterLoc').innerText = loc;
        document.getElementById('modalShelterCoord').innerText = coord;
        document.getElementById('modalShelterGuards').innerText = guards;
        document.getElementById('modalShelterStatus').innerText = status;
        document.getElementById('modalShelterCap').innerText = cap;
        document.getElementById('modalShelterDesc').innerText = desc || 'Posko dilengkapi kamera pantau dan protokol respon siaga 24 jam.';
        document.getElementById('shelterDetailModal').classList.remove('hidden');
    }

    function previewDuty(shelter, officer, shift, time, status, notes = '') {
        document.getElementById('dutyShelter').innerText = shelter;
        document.getElementById('dutyOfficer').innerText = officer;
        document.getElementById('dutyShift').innerText = shift;
        document.getElementById('dutyTime').innerText = time;
        document.getElementById('dutyStatus').innerText = status;
        document.getElementById('dutyNotes').innerText = notes || 'Piket rutin penjagaan & patroli posko.';
        document.getElementById('dutyPreviewModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function jumpToScheduleAndClose() {
        closeModal('shelterDetailModal');
        const scheduleEl = document.getElementById('jadwal-penjagaan');
        if (scheduleEl) {
            scheduleEl.scrollIntoView({ behavior: 'smooth' });
        }
    }

    let isAllSheltersExpanded = false;
    let currentShelterFilter = 'all';

    function toggleAllShelters() {
        isAllSheltersExpanded = !isAllSheltersExpanded;
        const label = document.getElementById('toggleShelterLabel');
        const icon = document.getElementById('toggleShelterIcon');
        const arrow = document.getElementById('toggleShelterArrow');
        const summary = document.getElementById('shelterCountSummary');

        if (isAllSheltersExpanded) {
            document.querySelectorAll('.shelter-extra').forEach(el => el.classList.remove('hidden'));
            if (label) label.innerText = 'Tutup Direktori Posko (Tampilkan 8)';
            if (icon) icon.innerText = 'view_agenda';
            if (arrow) arrow.innerText = 'expand_less';
            if (summary) summary.innerText = 'Menampilkan seluruh {{ $totalShelters }} Shelter Terdaftar';
        } else {
            document.querySelectorAll('.shelter-extra').forEach(el => el.classList.add('hidden'));
            if (label) label.innerText = 'Akses Direktori Lengkap ({{ $totalShelters }} Posko)';
            if (icon) icon.innerText = 'grid_view';
            if (arrow) arrow.innerText = 'arrow_forward';
            if (summary) summary.innerText = 'Menampilkan 8 dari {{ $totalShelters }} Shelter Terdaftar';
            const sec = document.getElementById('daftar-shelter');
            if (sec) sec.scrollIntoView({ behavior: 'smooth' });
        }
        applyShelterFilter();
    }

    function filterShelters(filterType, btn) {
        currentShelterFilter = filterType;
        const tabs = document.querySelectorAll('.filter-tab');
        tabs.forEach(tab => {
            tab.classList.remove('bg-[#14532d]', 'text-white', 'font-bold', 'shadow-sm');
            tab.classList.add('hover:text-secondary');
        });
        if (btn) {
            btn.classList.add('bg-[#14532d]', 'text-white', 'font-bold', 'shadow-sm');
            btn.classList.remove('hover:text-secondary');
        }
        applyShelterFilter();
    }

    function searchShelterCards() {
        applyShelterFilter();
    }

    function applyShelterFilter() {
        const searchInput = document.getElementById('shelterSearchInput');
        const searchVal = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const cards = document.querySelectorAll('.shelter-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const zone = card.getAttribute('data-zone') || '';
            const status = card.getAttribute('data-status') || '';
            const cardText = (card.innerText || '').toLowerCase();

            let matchFilter = false;
            if (currentShelterFilter === 'all') {
                matchFilter = true;
            } else if (currentShelterFilter.startsWith('Zona')) {
                matchFilter = (zone === currentShelterFilter);
            } else {
                matchFilter = (status === currentShelterFilter);
            }

            let matchSearch = !searchVal || cardText.includes(searchVal);

            if (currentShelterFilter !== 'all' || searchVal !== '') {
                // If filtered or searched, show from entire pool of 24
                if (matchFilter && matchSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            } else {
                // Default unfiltered state: respect expand/collapse
                const isExtra = card.classList.contains('shelter-extra');
                if (isAllSheltersExpanded || !isExtra) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            }
        });

        const summary = document.getElementById('shelterCountSummary');
        if (summary) {
            if (searchVal !== '' || currentShelterFilter !== 'all') {
                summary.innerText = `Ditemukan ${visibleCount} Posko Shelter sesuai filter`;
            } else if (isAllSheltersExpanded) {
                summary.innerText = `Menampilkan Seluruh ${visibleCount} dari {{ $totalShelters }} Shelter Terdaftar`;
            } else {
                summary.innerText = `Menampilkan 8 dari {{ $totalShelters }} Shelter Terdaftar`;
            }
        }
    }

    function highlightShelterSearch() {
        setTimeout(() => {
            const input = document.getElementById('shelterSearchInput');
            if (input) {
                input.focus();
                input.classList.add('ring-4', 'ring-emerald-400');
                setTimeout(() => input.classList.remove('ring-4', 'ring-emerald-400'), 1500);
            }
        }, 300);
    }

    function focusScheduleSearch() {
        setTimeout(() => {
            const input = document.getElementById('scheduleSearchInput');
            if (input) {
                input.focus();
                input.classList.add('ring-4', 'ring-emerald-400');
                setTimeout(() => input.classList.remove('ring-4', 'ring-emerald-400'), 1500);
            }
        }, 300);
    }

    function searchScheduleTable() {
        const input = document.getElementById('scheduleSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.schedule-row');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }

    function filterScheduleByShift(shift) {
        const rows = document.querySelectorAll('.schedule-row');
        rows.forEach(row => {
            if (shift === 'all' || row.getAttribute('data-shift') === shift) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Smooth scroll handler
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href').substring(1);
            if (targetId) {
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
</script>
</body>
</html>

