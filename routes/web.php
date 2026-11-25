<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShelterController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Dashboard & Management Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/emergency-alert', [DashboardController::class, 'emergencyAlert'])->name('emergency-alert');

    // Schedules - Check Conflict AJAX endpoint (placed before resource to avoid route conflict)
    Route::post('/schedules/check-conflict', [ScheduleController::class, 'checkConflict'])->name('schedules.check-conflict');
    Route::patch('/schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.update-status');

    // Core CRUD Resources
    Route::resource('shelters', ShelterController::class);
    Route::resource('officers', OfficerController::class);
    Route::resource('schedules', ScheduleController::class);

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Reports & Exports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/website', [SettingController::class, 'updateWebsite'])->name('settings.website');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs');
});
