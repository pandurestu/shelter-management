<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email atau Nomor Identitas wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Check if user exists by email or phone
        $user = User::where($loginField, $credentials['login'])->first();

        // If not found and input wasn't email, check if input matches admin email prefix or NRP
        if (! $user) {
            $user = User::where('email', $credentials['login'])->first();
        }

        if (! $user || ! Auth::attempt([$user->email ? 'email' : 'phone' => $user->email, 'password' => $credentials['password']], $request->boolean('remember'))) {
            // Also try direct email attempt
            if (! Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                    'login' => 'Kredensial yang diberikan tidak cocok dengan data personel kami.',
                ]);
            }
        }

        $request->session()->regenerate();

        ActivityLog::log(
            'LOGIN',
            'Autentikasi',
            'Pengguna '.Auth::user()->name.' berhasil masuk ke Command Dashboard Portal.'
        );

        return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $userName = Auth::user()?->name ?? 'Pengguna';

        ActivityLog::log(
            'LOGOUT',
            'Autentikasi',
            'Pengguna '.$userName.' telah mengakhiri sesi dan keluar dari sistem.'
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
