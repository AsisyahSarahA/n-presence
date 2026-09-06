<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Piket Dashboard') - {{ $appName ?? 'N-Presence' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Apply saved theme immediately in head before render to prevent flash
        (function() {
            const saved = localStorage.getItem('piket-theme');
            if (saved === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a5f',
                        accent: '#059669',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            touch-action: manipulation;
        }

        /* ========================================================
           SEMI-SKEUOMORPHISM DESIGN SYSTEM FOR PIKET SIDE
           ======================================================== */

        /* Raised Tactile Card */
        .skeuo-card {
            background: linear-gradient(180deg, #ffffff 0%, #fafbfd 100%);
            border: 1px solid #e2e8f0;
            border-top: 1px solid #ffffff;
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 6px 16px -3px rgba(15, 23, 42, 0.06);
            border-radius: 1.25rem;
        }
        .dark .skeuo-card {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                0 2px 4px rgba(0, 0, 0, 0.3),
                0 8px 20px -4px rgba(0, 0, 0, 0.5);
        }

        /* Inset Well */
        .skeuo-inset {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.05),
                inset 0 1px 2px rgba(0, 0, 0, 0.03),
                0 1px 0 #ffffff;
            border-radius: 0.875rem;
        }
        .dark .skeuo-inset {
            background: #090e17;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 
                inset 0 2px 5px rgba(0, 0, 0, 0.6),
                inset 0 1px 2px rgba(0, 0, 0, 0.4),
                0 1px 0 rgba(255, 255, 255, 0.04);
        }

        /* Tactile Input Fields */
        .skeuo-input {
            display: block;
            width: 100%;
            height: 2.75rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: #1e293b;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            box-shadow: 
                inset 0 2px 3px rgba(0, 0, 0, 0.04),
                0 1px 0 #ffffff;
            border-radius: 0.75rem;
            transition: all 0.15s ease;
        }
        .dark .skeuo-input {
            background: #0f172a;
            color: #f8fafc;
            border-color: #334155;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.4),
                0 1px 0 rgba(255, 255, 255, 0.05);
        }
        .skeuo-input:focus {
            background: #ffffff;
            border-color: #1e3a5f;
            box-shadow: 
                inset 0 1px 2px rgba(0, 0, 0, 0.03),
                0 0 0 3px rgba(30, 58, 95, 0.18),
                0 1px 2px rgba(0, 0, 0, 0.05);
            outline: none;
        }
        .dark .skeuo-input:focus {
            background: #0f172a;
            border-color: #38bdf8;
            box-shadow: 
                inset 0 1px 2px rgba(0, 0, 0, 0.4),
                0 0 0 3px rgba(56, 189, 248, 0.25);
        }
        select.skeuo-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 8l3 3 3-3'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem 1.25rem;
            padding-right: 2.5rem;
        }

        /* Tactile 3D Buttons */
        .skeuo-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 2.75rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 700;
            line-height: 1.25rem;
            border-radius: 0.75rem;
            transition: all 0.12s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .skeuo-btn:active {
            transform: translateY(2px) !important;
        }

        .skeuo-btn-primary {
            background: linear-gradient(180deg, #264b7a 0%, #172e4c 100%);
            border: 1px solid #132640;
            border-bottom: 3px solid #0c1726;
            color: #ffffff;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.28),
                0 2px 4px rgba(19, 38, 64, 0.2);
            border-radius: 0.75rem;
        }
        .skeuo-btn-primary:active {
            border-bottom-width: 1px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        .skeuo-btn-success {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            border: 1px solid #047857;
            border-bottom: 3px solid #065f46;
            color: #ffffff;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.35),
                0 2px 4px rgba(5, 150, 105, 0.25);
            border-radius: 0.75rem;
        }
        .skeuo-btn-success:active {
            border-bottom-width: 1px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .skeuo-btn-light {
            background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
            border: 1px solid #cbd5e1;
            border-bottom: 3px solid #94a3b8;
            color: #334155;
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
        }
        .dark .skeuo-btn-light {
            background: linear-gradient(180deg, #334155 0%, #1e293b 100%);
            border: 1px solid #475569;
            border-bottom: 3px solid #0f172a;
            color: #f1f5f9;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .skeuo-btn-light:active {
            border-bottom-width: 1px;
            box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.15);
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 text-slate-800 dark:bg-slate-950 dark:text-slate-100 font-sans min-h-screen flex flex-col justify-between pb-20 transition-colors duration-300">

    <!-- Topbar Header (Tactile Elevated Bar) -->
    <header class="h-14 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/90 dark:border-slate-800 flex items-center justify-between px-4 sticky top-0 z-50 shadow-[0_2px_4px_rgba(0,0,0,0.02),0_1px_0_#ffffff] dark:shadow-[0_2px_8px_rgba(0,0,0,0.4),0_1px_0_rgba(255,255,255,0.05)] transition-colors duration-300">
        <div class="flex items-center space-x-2 min-w-0">
            @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                <img src="{{ asset($appLogo) }}" alt="{{ $appName ?? 'Logo' }}" class="w-7 h-7 object-contain rounded-lg bg-white/10 p-0.5 border border-slate-200 dark:border-white/10 shadow-sm shrink-0">
            @endif
            <span class="text-base font-bold tracking-wide text-slate-800 dark:text-white truncate">{{ $appName ?? 'N-Presence' }}</span>
            <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400 text-[10px] font-bold rounded-full hidden sm:inline border border-emerald-300 dark:border-emerald-500/30 shadow-sm shrink-0">Piket</span>

            <!-- Navbar Watermark Credit -->
            <span class="hidden md:inline-flex items-center text-[10px] text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 rounded-full border border-slate-200 dark:border-slate-700 ml-2 truncate shadow-inner">
                Oleh <strong class="ml-1 text-slate-700 dark:text-slate-300">KKN 02 2026 LP3I Desa Nangtang (Manajemen Informatika)</strong>
            </span>
        </div>

        <div class="flex items-center space-x-2.5 shrink-0">
            <!-- Dark/Light Toggle (Tactile Button) -->
            <button id="theme-toggle" type="button" aria-label="Toggle Theme" class="skeuo-btn skeuo-btn-light p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 rounded-xl transition-all">
                <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="skeuo-btn skeuo-btn-light text-xs font-bold py-1.5 px-3 text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 transition-all flex items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 overflow-y-auto">
        @yield('content')
    </main>

    <!-- Watermark Footer for Piket Side -->
    <footer class="px-4 py-2 text-center text-[10px] text-slate-400 dark:text-slate-500">
        <span>Oleh <strong class="text-slate-600 dark:text-slate-400">KKN 02 2026 LP3I Desa Nangtang (Manajemen Informatika)</strong></span>
    </footer>

    <!-- Bottom Navigation Bar (Tactile Dock Tray) -->
    <nav class="fixed bottom-0 inset-x-0 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200/90 dark:border-slate-800 h-16 flex items-center justify-around px-3 z-50 shadow-[0_-4px_16px_rgba(0,0,0,0.06)] dark:shadow-[0_-4px_20px_rgba(0,0,0,0.5)] transition-colors duration-300">

        <!-- Tab: Home/Dashboard -->
        <a href="{{ route('piket.dashboard') }}"
           class="flex flex-col items-center justify-center py-1 px-4 rounded-xl transition-all {{ request()->routeIs('piket.dashboard') ? 'text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 shadow-inner' : 'text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21.75h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h8.25" />
            </svg>
            <span class="text-[10px] mt-0.5">Beranda</span>
        </a>

        <!-- Tab: Scan Masuk / Pulang -->
        <a href="{{ route('piket.scanner') }}"
           class="flex flex-col items-center justify-center py-1 px-4 rounded-xl transition-all {{ request()->routeIs('piket.scanner') ? 'text-blue-600 dark:text-blue-400 font-bold bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 shadow-inner' : 'text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <div class="relative flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
                <span class="absolute -top-1.5 -right-2 text-[7px] bg-emerald-600 text-white px-1 py-0.2 rounded-full font-extrabold shadow-sm">IN/OUT</span>
            </div>
            <span class="text-[10px] mt-0.5">Scanner</span>
        </a>

        <!-- Tab: Daftar Hadir Hari Ini -->
        <a href="{{ route('piket.today') }}"
           class="flex flex-col items-center justify-center py-1 px-4 rounded-xl transition-all {{ request()->routeIs('piket.today') ? 'text-purple-600 dark:text-purple-400 font-bold bg-purple-50 dark:bg-purple-500/15 border border-purple-200 dark:border-purple-500/30 shadow-inner' : 'text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm0 5.25h.007v.008H3.75V12Zm0 5.25h.007v.008H3.75v-.008Z" />
            </svg>
            <span class="text-[10px] mt-0.5">Daftar Hadir</span>
        </a>

    </nav>

    <!-- SweetAlert2 Toast Script -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        // Theme Toggle Handler
        (function() {
            const html = document.documentElement;
            const toggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            function syncIcons() {
                const isDark = html.classList.contains('dark');
                if (isDark) {
                    if (sunIcon) sunIcon.classList.remove('hidden');
                    if (moonIcon) moonIcon.classList.add('hidden');
                } else {
                    if (sunIcon) sunIcon.classList.add('hidden');
                    if (moonIcon) moonIcon.classList.remove('hidden');
                }
            }

            function toggleTheme() {
                const isDarkNow = html.classList.contains('dark');
                if (isDarkNow) {
                    html.classList.remove('dark');
                    localStorage.setItem('piket-theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('piket-theme', 'dark');
                }
                syncIcons();
            }

            // Sync icon on page load
            syncIcons();

            if (toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleTheme();
                });
            }
        })();

        // Register PWA Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('[PWA] Service Worker registered successfully:', reg.scope))
                    .catch(err => console.error('[PWA] Service Worker registration failed:', err));
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
