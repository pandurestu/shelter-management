<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $settings = [
            'site_name' => Setting::get('site_name', 'Shelter Management System'),
            'site_tagline' => Setting::get('site_tagline', 'PENJAGAAN SATWA & BENCANA TERPADU'),
            'hotline_toll_free' => Setting::get('hotline_toll_free', '1500 - 8989'),
            'hotline_office' => Setting::get('hotline_office', '+62 21 555-8910'),
            'emergency_radio' => Setting::get('emergency_radio', '144.520 MHz (Kanal Darurat)'),
            'coordination_email' => Setting::get('coordination_email', 'posko@shelter-system.go.id'),
            'coordination_unit' => Setting::get('coordination_unit', 'Satgas Penjagaan Wilayah'),
            'command_center_address' => Setting::get('command_center_address', 'Posko Induk Pusat Komando Wilayah'),
            'operational_status' => Setting::get('operational_status', 'Level 1 Siaga Operasional'),
        ];

        return view('admin.settings.index', compact('user', 'settings'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:50',
            'avatar' => 'nullable|url',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user->update($validated);

        ActivityLog::log(
            'UPDATE',
            'Pengaturan',
            'Pengguna '.$user->name.' memperbarui informasi profil akun.'
        );

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string|current_password',
            'new_password' => ['required', 'string', Password::min(6), 'confirmed'],
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok dengan catatan kami.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'new_password.min' => 'Kata sandi baru minimal harus 6 karakter.',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        ActivityLog::log(
            'UPDATE',
            'Pengaturan',
            'Pengguna '.$user->name.' telah mengubah kata sandi akun.'
        );

        return back()->with('success', 'Kata sandi berhasil diubah! Gunakan kata sandi baru pada login berikutnya.');
    }

    public function updateWebsite(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'hotline_toll_free' => 'nullable|string|max:50',
            'hotline_office' => 'nullable|string|max:50',
            'emergency_radio' => 'nullable|string|max:100',
            'coordination_email' => 'nullable|email|max:255',
            'coordination_unit' => 'nullable|string|max:255',
            'command_center_address' => 'nullable|string',
            'operational_status' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val);
        }

        ActivityLog::log(
            'UPDATE',
            'Pengaturan',
            'Pengguna '.auth()->user()->name.' memperbarui konfigurasi informasi website.'
        );

        return back()->with('success', 'Informasi website & konfigurasi posko berhasil diperbarui.');
    }
}
