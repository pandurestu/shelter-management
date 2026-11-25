<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Shelter Management System - Taman Safari Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#14532d",
                        "brand-forest": "#14532d",
                        "secondary": "#15803d",
                        "brand-deep": "#052e16",
                    }
                }
            }
        }
    </script>
</head>
<body class="relative min-h-screen flex items-center justify-center p-4 font-['Inter'] text-slate-800 bg-slate-900 overflow-x-hidden">

    <!-- Background Image (Taman Safari Gate) with Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat transform scale-105 transition-transform duration-1000" style="background-image: url('{{ asset('images/login-bg.jpg') }}');"></div>
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-black/85 via-black/55 to-emerald-950/75 backdrop-blur-[2px]"></div>

    <div class="relative z-10 w-full max-w-md my-8">
        <!-- Logo & Title Header -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center p-3.5 rounded-2xl bg-white shadow-2xl mb-3 hover:scale-105 transition-transform border border-emerald-100 group" title="Kembali ke Halaman Home">
                <img src="{{ asset('images/logo.png') }}" alt="Taman Safari Bogor Logo" class="h-20 w-auto object-contain">
            </a>
            <h1 class="text-2xl font-extrabold text-white font-['Plus_Jakarta_Sans'] tracking-tight drop-shadow-md">SHELTER MANAGEMENT SYSTEM</h1>
            <p class="text-xs text-emerald-300 font-bold uppercase tracking-wider mt-1 drop-shadow">PENJAGAAN SATWA &amp; BENCANA TERPADU</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-white/40 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-emerald-500/10 pointer-events-none blur-2xl"></div>

            <div class="mb-6">
                <div class="flex items-center gap-2 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-1">
                    <span class="material-symbols-outlined text-[16px]">lock</span>
                    <span>Masuk Portal Operasional</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 font-['Plus_Jakarta_Sans']">Autentikasi Akun</h2>
                <p class="text-xs text-slate-500 mt-1">Masukkan kredensial admin untuk mengakses dashboard kendali posko.</p>
            </div>

            <!-- Error Notification -->
            @if(session('error') || $errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-rose-600 text-[18px] shrink-0 mt-0.5">error</span>
                    <div class="flex-1">
                        @if(session('error'))
                            <span>{{ session('error') }}</span>
                        @endif
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-[18px]">info</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email / Nomor Identitas Personel</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">person</span>
                        <input type="text" name="login" value="{{ old('login', 'admin@shelter.com') }}" required autofocus
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600/30 focus:border-emerald-600 transition-all placeholder:text-slate-400"
                            placeholder="admin@shelter.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">key</span>
                        <input type="password" id="password-input" name="password" value="TamanSafari2026" required
                            class="w-full pl-9 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600/30 focus:border-emerald-600 transition-all placeholder:text-slate-400"
                            placeholder="TamanSafari2026">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-[18px]" id="eye-icon">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-1.5 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" checked>
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-[#14532d] hover:bg-[#166534] text-white text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2 mt-2 hover:scale-[1.01]">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

            <!-- Back to Home Link -->
            <div class="text-center mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-emerald-700 flex items-center justify-center gap-1.5 font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Halaman Home</span>
                </a>
            </div>
        </div>

        <div class="text-center text-xs text-white/80 mt-6 drop-shadow">
            &copy; {{ date('Y') }} Shelter Management System. Seluruh hak cipta dilindungi.
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pass = document.getElementById('password-input');
            const icon = document.getElementById('eye-icon');
            if (pass.type === 'password') {
                pass.type = 'text';
                icon.innerText = 'visibility_off';
            } else {
                pass.type = 'password';
                icon.innerText = 'visibility';
            }
        }
    </script>
</body>
</html>
