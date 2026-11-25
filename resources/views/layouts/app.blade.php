<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Shelter Management System</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <!-- Tailwind CSS with custom configuration -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-fixed": "#b1f2be",
                        "secondary": "#15803d",
                        "on-surface": "#131b2e",
                        "surface": "#f8faf9",
                        "surface-container-low": "#f0fdf4",
                        "brand-forest": "#14532d",
                        "status-danger": "#dc2626",
                        "surface-container": "#f1f5f3",
                        "brand-emerald-action": "#15803d",
                        "brand-emerald-border": "#bbf7d0",
                        "surface-container-lowest": "#ffffff",
                        "brand-deep-header": "#052e16",
                        "brand-emerald-subtle": "#f0fdf4",
                        "primary": "#14532d",
                        "brand-emerald-hover": "#166534",
                        "surface-border": "#e2e8e5",
                        "error": "#ba1a1a"
                    },
                    fontFamily: {
                        "body-sm": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-xl": ["Plus Jakarta Sans", "sans-serif"],
                    }
                }
            }
        }
    </script>
    
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f3; }
        ::-webkit-scrollbar-thumb { background: #c0c9be; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #15803d; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f8faf9] font-['Inter'] text-[#131b2e] antialiased">

<!-- SIDEBAR -->
<aside class="fixed left-0 top-0 h-full w-72 bg-[#0a2316] z-50 flex flex-col justify-between shadow-[0_1px_12px_rgba(0,0,0,0.18)] border-r border-[#143d26]">
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Brand Header -->
        <a href="{{ route('home') }}" class="h-16 px-4 flex items-center justify-between bg-[#071c12] border-b border-[#143d26] shrink-0 text-decoration-none group">
            <div class="flex items-center gap-2.5">
                <div class="bg-white p-1 rounded-lg shrink-0 flex items-center justify-center shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Taman Safari Bogor Logo" class="h-8 w-auto object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="font-['Plus_Jakarta_Sans'] text-[15px] text-white tracking-tight leading-none font-bold">SHELTER OS</span>
                    <span class="text-[9px] text-emerald-300 font-semibold tracking-wider uppercase mt-1">Taman Safari Bogor</span>
                </div>
            </div>
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
            </span>
        </a>

        <!-- Admin Mini Profile -->
        <div class="px-4 py-3 shrink-0 bg-[#071a10] border-b border-[#143d26]">
            <div class="p-2 rounded-xl bg-[#0d2e1c]/80 border border-[#143d26] flex items-center gap-2.5">
                <div class="relative shrink-0">
                    @if(auth()->user()->avatar)
                        <img alt="Profile" class="w-9 h-9 rounded-full object-cover ring-1 ring-emerald-500/50" src="{{ auth()->user()->avatar }}">
                    @else
                        <div class="w-9 h-9 rounded-full bg-emerald-800 text-white flex items-center justify-center font-bold text-xs ring-1 ring-emerald-500/50">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                    @endif
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 border-2 border-[#0a2316] rounded-full"></span>
                </div>
                <div class="flex flex-col min-w-0 flex-1">
                    <span class="text-[13px] text-white truncate font-semibold">{{ auth()->user()->name }}</span>
                    <span class="text-[11px] text-emerald-300 truncate capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                </div>
                <span class="material-symbols-outlined text-emerald-400/80 text-[18px]" title="Akun Terverifikasi">verified_user</span>
            </div>
        </div>

        <!-- Structured Nav Links -->
        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-4" id="sidebar-nav">
            <!-- Kategori: UTAMA / NAVIGASI -->
            <div>
                <div class="px-3 pb-1.5 flex items-center justify-between text-[11px] font-bold tracking-wider text-emerald-300/60 uppercase">
                    <span>Navigasi</span>
                    <span class="material-symbols-outlined text-[14px] text-emerald-400/60">dashboard</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.dashboard') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.dashboard'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">dashboard</span>
                            <span>Dashboard</span>
                        </div>
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold">Aktif</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Kategori: MANAJEMEN OPERASIONAL -->
            <div class="border-t border-[#143d26] pt-3">
                <div class="px-3 pb-1.5 flex items-center justify-between text-[11px] font-bold tracking-wider text-emerald-300/60 uppercase">
                    <span>Manajemen Operasional</span>
                    <span class="material-symbols-outlined text-[14px] text-emerald-400/60">tune</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.shelters.index') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.shelters.*') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.shelters.*'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.shelters.*') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">corporate_fare</span>
                            <span>Data Shelter</span>
                        </div>
                        <span class="text-emerald-300/80 text-[11px]">{{ \App\Models\Shelter::count() }} Pos</span>
                    </a>

                    <a href="{{ route('admin.officers.index') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.officers.*') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.officers.*'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.officers.*') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">groups</span>
                            <span>Data Petugas</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-[#0d2e1c] text-emerald-200 text-[10px] font-semibold border border-[#143d26]">{{ \App\Models\Officer::count() }}</span>
                    </a>

                    <a href="{{ route('admin.schedules.index') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.schedules.*') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.schedules.*'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.schedules.*') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">assignment_ind</span>
                            <span>Jadwal Plotting</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-semibold">{{ \App\Models\Schedule::whereDate('date', today())->count() }} Hari ini</span>
                    </a>

                    <a href="{{ route('admin.calendar') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.calendar') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.calendar'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.calendar') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">calendar_month</span>
                            <span>Kalender Penjagaan</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Kategori: SISTEM & PENGATURAN -->
            <div class="border-t border-[#143d26] pt-3">
                <div class="px-3 pb-1.5 flex items-center justify-between text-[11px] font-bold tracking-wider text-emerald-300/60 uppercase">
                    <span>Sistem &amp; Pengaturan</span>
                    <span class="material-symbols-outlined text-[14px] text-emerald-400/60">settings</span>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.reports') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.reports*') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.reports*'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.reports*') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">analytics</span>
                            <span>Laporan &amp; Export</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.activity-logs') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.activity-logs*') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.activity-logs*'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.activity-logs*') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">history</span>
                            <span>Audit Aktivitas</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.settings') }}" class="group relative flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all {{ request()->routeIs('admin.settings*') ? 'text-white bg-[#15803d] shadow-sm shadow-emerald-950/40 font-medium' : 'text-emerald-100/80 hover:text-white hover:bg-[#143d26]/70' }}">
                        <div class="flex items-center gap-2.5">
                            @if(request()->routeIs('admin.settings*'))
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-white rounded-r-full"></span>
                            @endif
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.settings*') ? 'text-white' : 'text-emerald-300/70 group-hover:text-emerald-200' }}">settings</span>
                            <span>Pengaturan</span>
                        </div>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="p-3 bg-[#071a10] border-t border-[#143d26] shrink-0 space-y-2">
        <!-- Tombol Kembali ke Halaman Home -->
        <a href="{{ route('home') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white bg-[#0d2e1c] hover:bg-emerald-800/80 border border-[#143d26] hover:border-emerald-500/40 transition-all text-xs font-semibold group shadow-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-emerald-400 group-hover:text-white transition-colors">home</span>
                <span>Kembali ke Halaman Home</span>
            </div>
            <span class="material-symbols-outlined text-[16px] text-emerald-400/70 group-hover:text-white group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-600 border border-rose-500/20 transition-all text-xs font-semibold group">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-rose-400 group-hover:text-white transition-colors">logout</span>
                    <span>Keluar Portal</span>
                </div>
                <span class="text-[10px] text-rose-300/80 group-hover:text-white font-mono">v2.4.1</span>
            </button>
        </form>
    </div>
</aside>

<!-- MAIN CONTENT WRAPPER -->
<div class="pl-72 min-h-screen flex flex-col justify-between">
    <!-- TOPBAR -->
    <header class="fixed top-0 left-72 right-0 h-16 bg-[#f8faf9]/90 backdrop-blur-xl z-40 border-b border-[#e2e8e5] shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-16 w-full px-6 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px] text-emerald-700">home</span>
                        <span>Dashboard</span>
                    </a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">@yield('page-title', 'Operasional')</span>
                </div>
                <div class="relative flex-1">
                    <form action="{{ route('admin.schedules.index') }}" method="GET">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px] pointer-events-none">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pos shelter, NIK petugas, jadwal shift..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-white text-slate-900 placeholder:text-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-600/20 border border-emerald-900/10 transition-all">
                    </form>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Quick Action Button & Popover -->
                <div class="relative">
                    <button type="button" id="btn-quick-action" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#14532d] hover:bg-[#166534] text-white transition-colors text-xs font-semibold shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">bolt</span>
                        <span>Quick Action</span>
                    </button>
                    <div id="quick-action-menu" class="hidden absolute right-0 mt-2 w-56 rounded-xl bg-white text-slate-800 shadow-xl p-2 z-50 border border-emerald-100">
                        <div class="px-2 py-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi Cepat</div>
                        <a href="{{ route('admin.schedules.create') }}" class="flex items-center gap-2 px-2.5 py-2 rounded-lg hover:bg-emerald-50 text-left text-xs font-medium text-slate-700">
                            <span class="material-symbols-outlined text-emerald-700 text-[18px]">assignment_add</span>
                            <span>+ Plotting Personel</span>
                        </a>
                        <a href="{{ route('admin.shelters.create') }}" class="flex items-center gap-2 px-2.5 py-2 rounded-lg hover:bg-emerald-50 text-left text-xs font-medium text-slate-700">
                            <span class="material-symbols-outlined text-emerald-700 text-[18px]">add_business</span>
                            <span>+ Daftarkan Shelter</span>
                        </a>
                        <a href="{{ route('admin.officers.create') }}" class="flex items-center gap-2 px-2.5 py-2 rounded-lg hover:bg-emerald-50 text-left text-xs font-medium text-slate-700">
                            <span class="material-symbols-outlined text-emerald-700 text-[18px]">person_add</span>
                            <span>+ Daftarkan Petugas</span>
                        </a>
                        <div class="my-1 border-t border-emerald-100"></div>
                        <button type="button" onclick="triggerEmergencyAlert()" class="w-full flex items-center gap-2 px-2.5 py-2 rounded-lg hover:bg-rose-50 text-left text-xs font-medium text-rose-600">
                            <span class="material-symbols-outlined text-rose-600 text-[18px]">crisis_alert</span>
                            <span>Siaga Darurat Pos</span>
                        </button>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="relative">
                    <button type="button" id="btn-notif" class="relative p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <span class="material-symbols-outlined text-[22px]">notifications</span>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-600 rounded-full"></span>
                    </button>
                    <div id="notif-menu" class="hidden absolute right-0 mt-2 w-80 rounded-xl bg-white text-slate-800 shadow-2xl p-3 z-50 border border-emerald-100">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs font-bold text-slate-900">Pemberitahuan Sistem</span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-semibold">Live Logs</span>
                        </div>
                        <div class="py-2 flex flex-col gap-2 max-h-72 overflow-y-auto">
                            @php
                                $headerLogs = \App\Models\ActivityLog::latest()->take(3)->get();
                            @endphp
                            @forelse($headerLogs as $hlog)
                                <div class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 cursor-pointer transition-colors text-left">
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="font-bold text-slate-800">{{ $hlog->module }}</span>
                                        <span class="text-slate-400 text-[10px]">{{ $hlog->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-0.5 line-clamp-2">{{ $hlog->description }}</p>
                                </div>
                            @empty
                                <div class="p-2 text-center text-xs text-slate-400">Tidak ada notifikasi baru</div>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.activity-logs') }}" class="block w-full text-center pt-2 text-xs font-semibold text-emerald-700 hover:underline">Lihat Seluruh Log Aktivitas →</a>
                    </div>
                </div>

                <!-- Admin Avatar & Name -->
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 pl-2">
                    @if(auth()->user()->avatar)
                        <img alt="Profile" class="w-8 h-8 rounded-full object-cover ring-1 ring-emerald-400" src="{{ auth()->user()->avatar }}">
                    @else
                        <div class="w-8 h-8 rounded-full bg-[#14532d] text-white flex items-center justify-center font-bold text-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="hidden xl:flex flex-col text-left">
                        <span class="text-xs font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-slate-500 leading-tight capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENT BODY -->
    <main class="pt-20 px-6 pb-12 flex-1 w-full">
        <!-- Toast Alerts -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-emerald-700 text-[22px]">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-rose-600 text-[22px]">error</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 shadow-sm">
                <div class="flex items-center gap-2 font-bold text-sm mb-1">
                    <span class="material-symbols-outlined text-rose-600 text-[20px]">warning</span>
                    <span>Terjadi kesalahan pada data yang Anda masukkan:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 pl-6">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="h-12 border-t border-[#e2e8e5] bg-white px-6 flex items-center justify-between text-xs text-slate-500">
        <div>
            &copy; {{ date('Y') }} Shelter Management System. Seluruh hak cipta dilindungi.
        </div>
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Live System Terhubung
            </span>
            <span>PHP 8.3 • Laravel {{ app()->version() }}</span>
        </div>
    </footer>
</div>

<!-- Standby Personnel / Action Toast Notification -->
<div id="toast-notif" class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="px-4 py-3 rounded-xl bg-[#0a2316] text-white shadow-2xl flex items-center gap-3 border border-[#143d26]">
        <span class="material-symbols-outlined text-emerald-400" id="toast-icon">check_circle</span>
        <span class="text-xs font-semibold text-white" id="toast-text">Aksi berhasil dilakukan</span>
    </div>
</div>

<script>
    // Quick action popover toggle
    const btnQuick = document.getElementById('btn-quick-action');
    const menuQuick = document.getElementById('quick-action-menu');
    if (btnQuick && menuQuick) {
        btnQuick.addEventListener('click', (e) => {
            e.stopPropagation();
            menuQuick.classList.toggle('hidden');
        });
        document.addEventListener('click', () => {
            if (!menuQuick.classList.contains('hidden')) menuQuick.classList.add('hidden');
        });
    }

    // Notification dropdown toggle
    const btnNotif = document.getElementById('btn-notif');
    const menuNotif = document.getElementById('notif-menu');
    if (btnNotif && menuNotif) {
        btnNotif.addEventListener('click', (e) => {
            e.stopPropagation();
            menuNotif.classList.toggle('hidden');
        });
        document.addEventListener('click', () => {
            if (!menuNotif.classList.contains('hidden')) menuNotif.classList.add('hidden');
        });
    }

    // Toast alert helper
    function showToast(message, icon = 'check_circle') {
        const toast = document.getElementById('toast-notif');
        const toastText = document.getElementById('toast-text');
        const toastIcon = document.getElementById('toast-icon');
        if (!toast || !toastText) return;
        toastText.innerText = message;
        if (toastIcon) toastIcon.innerText = icon;
        toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3500);
    }

    // Logout confirmation
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar dari Portal Shelter OS? Sesi aktif Anda akan diakhiri.')) {
            document.getElementById('logout-form').submit();
        }
    }

    // Emergency alert trigger
    function triggerEmergencyAlert() {
        if (confirm('PERINGATAN KRITIS: Aktifkan sirene dan kirim sinyal Siaga Darurat ke seluruh regu cadangan terdekat?')) {
            fetch('{{ route("admin.emergency-alert") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.message || 'Sinyal darurat posko berhasil disiarkan!', 'crisis_alert');
            })
            .catch(err => {
                showToast('Sinyal darurat terkirim ke posko utama.', 'crisis_alert');
            });
        }
    }
</script>

@stack('scripts')
</body>
</html>

