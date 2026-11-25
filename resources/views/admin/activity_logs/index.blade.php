@extends('layouts.app')

@section('title', 'Log Aktivitas & Audit')
@section('page-title', 'Audit Trail Aktivitas')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Log Aktivitas &amp; Audit Trail</h1>
            <p class="text-xs text-slate-500 mt-1">Rekam jejak seluruh mutasi data plotting, perubahan status shelter, dan aktivitas login personel.</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="rounded-2xl bg-white p-4 shadow-sm border border-emerald-900/10 mb-6">
        <form method="GET" action="{{ route('admin.activity-logs') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Cari Keterangan / Pelaku</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan, nama personel..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Modul Terkait</label>
                <select name="module" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Modul</option>
                    @foreach($modules as $m)
                        <option value="{{ $m }}" {{ request('module') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Aksi</label>
                <select name="action" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                    <option value="all">Semua Jenis Aksi</option>
                    @foreach($actions as $a)
                        <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                @if(request()->anyFilled(['search', 'module', 'action']))
                    <a href="{{ route('admin.activity-logs') }}" class="w-full py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold text-center transition-colors">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Logs List -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-emerald-900/10 mb-6">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Waktu &amp; Tanggal</th>
                        <th class="py-3 px-4">Pelaku / Pengguna</th>
                        <th class="py-3 px-4">Aksi</th>
                        <th class="py-3 px-4">Modul</th>
                        <th class="py-3 px-4">Deskripsi Rinci Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($logs as $idx => $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-center text-slate-400">{{ $logs->firstItem() + $idx }}</td>
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-600 whitespace-nowrap">
                                {{ $log->created_at->translatedFormat('d/m/Y H:i:s') }}
                                <span class="block text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $log->user_name }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $actionColors = [
                                        'CREATE' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'UPDATE' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'DELETE' => 'bg-rose-100 text-rose-800 border-rose-200',
                                        'LOGIN' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'LOGOUT' => 'bg-slate-100 text-slate-700 border-slate-200',
                                        'EXPORT' => 'bg-teal-100 text-teal-800 border-teal-200',
                                        'EMERGENCY' => 'bg-rose-600 text-white font-extrabold',
                                    ];
                                    $actClass = $actionColors[$log->action] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $actClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-emerald-800">{{ $log->module }}</td>
                            <td class="py-3 px-4 text-slate-700 max-w-md">{{ $log->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada catatan log aktivitas yang sesuai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection

