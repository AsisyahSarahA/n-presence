<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $appName ?? 'N-Presence' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a5f',
                        'primary-dark': '#182e4b',
                        'primary-deep': '#0f1d30',
                        secondary: '#3b82f6',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .skeuo-card {
            background: linear-gradient(180deg, #ffffff 0%, #fafbfd 100%);
            border: 1px solid #e2e8f0;
            border-top: 1px solid #ffffff;
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 12px 28px -4px rgba(15, 23, 42, 0.12);
        }
        .skeuo-inset {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.06),
                0 1px 0 #ffffff;
        }
        .skeuo-input {
            height: 2.75rem;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.05),
                0 1px 0 #ffffff;
            transition: all 0.15s ease-in-out;
        }
        .skeuo-input:focus {
            background: #ffffff;
            border-color: #1e3a5f;
            box-shadow: 
                inset 0 1px 2px rgba(0, 0, 0, 0.04),
                0 0 0 3px rgba(30, 58, 95, 0.15);
            outline: none;
        }
        .skeuo-btn-primary {
            height: 2.75rem;
            background: linear-gradient(180deg, #254670 0%, #1e3a5f 55%, #182e4b 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.35);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.15);
            border-bottom: 3px solid #0f1d30;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.25),
                0 3px 6px rgba(15, 23, 42, 0.25);
            transition: all 0.1s ease-in-out;
        }
        .skeuo-btn-primary:hover {
            filter: brightness(1.05);
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                0 4px 8px rgba(15, 23, 42, 0.3);
        }
        .skeuo-btn-primary:active {
            transform: translateY(2px);
            border-bottom-width: 1px;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.4),
                0 1px 2px rgba(15, 23, 42, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">

    <div class="w-full max-w-md skeuo-card rounded-2xl overflow-hidden transition-all duration-300 relative">
        <!-- Subtle Top Specular Accent -->
        <div class="h-1.5 w-full bg-gradient-to-r from-primary via-[#2d558a] to-primary"></div>

        <div class="p-8 sm:p-9">
            <!-- Header/Logo (Centered) -->
            <div class="text-center mb-8">
                @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                    <div class="mb-4 flex justify-center">
                        <div class="p-3 bg-white rounded-2xl border border-slate-200 shadow-[inset_0_1px_0_#ffffff,0_4px_10px_rgba(0,0,0,0.06)] transition-transform hover:scale-105">
                            <img src="{{ asset($appLogo) }}" alt="{{ $appName ?? 'Logo' }}" class="h-16 w-auto max-w-[160px] object-contain drop-shadow-sm">
                        </div>
                    </div>
                @else
                    <div class="w-16 h-16 bg-gradient-to-b from-[#244570] to-primary text-white rounded-2xl flex items-center justify-center mx-auto mb-4 border-t border-t-white/30 border-b-2 border-b-slate-900 shadow-[inset_0_1px_0_rgba(255,255,255,0.25),0_4px_10px_rgba(15,23,42,0.2)]">
                        <!-- Icon Key/Lock (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                @endif
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $appName ?? 'N-Presence' }}</h1>
                <p class="text-xs text-slate-500 mt-1.5 font-medium max-w-xs mx-auto leading-relaxed">{{ $appDescription ?? 'Sistem Absensi SMPN SATU ATAP 1 CIGALONTANG' }}</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-5 p-4 bg-rose-50 border border-rose-200 border-l-4 border-l-rose-500 text-rose-800 rounded-xl text-xs font-semibold shadow-[inset_0_1px_0_#ffffff]">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="username" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                            <!-- User Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </span>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input"
                            placeholder="Masukkan username">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                            <!-- Lock Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center text-xs font-semibold text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary rounded border-slate-300 focus:ring-primary">
                        <span class="ml-2">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full skeuo-btn-primary text-white font-bold py-3 px-4 rounded-xl flex items-center justify-center space-x-2 cursor-pointer mt-2 text-sm tracking-wide">
                    <span>Masuk ke Sistem</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Footer Deck -->
        <div class="px-8 py-4 bg-slate-50/90 border-t border-slate-200/80 shadow-[inset_0_1px_0_#ffffff] text-center">
            <span class="text-[11px] text-slate-500 font-medium">
                {{ $appFooter ?? '© 2026 KKN Kelompok 02 Cigalontang. All rights reserved.' }}
            </span>
        </div>
    </div>

</body>
</html>

