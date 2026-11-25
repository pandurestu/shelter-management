<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::orderBy('created_at', 'desc');

        if ($request->filled('module') && $request->module !== 'all') {
            $query->where('module', $request->module);
        }

        if ($request->filled('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $modules = ['Shelter', 'Petugas', 'Jadwal', 'Autentikasi', 'Pengaturan', 'Laporan', 'Sistem'];
        $actions = ['CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT', 'EXPORT', 'EMERGENCY', 'BACKUP'];

        return view('admin.activity_logs.index', compact('logs', 'modules', 'actions'));
    }
}
