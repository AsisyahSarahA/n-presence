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
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 text-slate-800 dark:bg-slate-950 dark:text-slate-100 font-sans min-h-screen flex flex-col justify-between pb-16 transition-colors duration-300">

    <!-- Topbar Header -->
    <header class="h-14 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 sticky top-0 z-50 transition-colors duration-300">
        <div class="flex items-center space-x-2">
            @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                <img src="{{ asset($appLogo) }}" alt="{{ $appName ?? 'Logo' }}" class="w-6 h-6 object-contain rounded-md bg-white/10 p-0.5">
            @endif
            <span class="text-base font-bold tracking-wide text-slate-800 dark:text-white">{{ $appName ?? 'N-Presence' }}</span>
            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400 text-[10px] font-semibold rounded-full hidden sm:inline border border-emerald-200 dark:border-emerald-500/30">Piket</span>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Dark/Light Toggle -->
            <button id="theme-toggle" type="button" aria-label="Toggle Theme" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-all p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>

            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 font-medium py-1 px-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 overflow-y-auto">
        @yield('content')
    </main>

    <!-- Bottom Navigation Bar -->
    <nav class="fixed bottom-0 inset-x-0 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 h-16 flex items-center justify-around px-2 z-50 shadow-sm dark:shadow-lg transition-colors duration-300">

        <!-- Tab: Home/Dashboard -->
        <a href="{{ route('piket.dashboard') }}"
           class="flex flex-col items-center justify-center w-20 h-full transition-all {{ request()->routeIs('piket.dashboard') ? 'text-emerald-600 dark:text-accent font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21.75h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h8.25" />
            </svg>
            <span class="text-[10px] mt-1 font-medium">Beranda</span>
        </a>

        <!-- Tab: Scan Masuk -->
        <a href="{{ route('piket.scanner') }}"
           class="flex flex-col items-center justify-center w-20 h-full transition-all {{ request()->routeIs('piket.scanner') ? 'text-emerald-600 dark:text-accent font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300' }}">
            <div class="relative flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
                <span class="absolute -top-1.5 -right-1 text-[8px] bg-emerald-600 text-white px-1 rounded-full font-bold">IN/OUT</span>
            </div>
            <span class="text-[10px] mt-1 font-medium">Scanner</span>
        </a>

        <!-- Tab: Daftar Hadir Hari Ini -->
        <a href="{{ route('piket.today') }}"
           class="flex flex-col items-center justify-center w-20 h-full transition-all {{ request()->routeIs('piket.today') ? 'text-emerald-600 dark:text-accent font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm0 5.25h.007v.008H3.75V12Zm0 5.25h.007v.008H3.75v-.008Z" />
            </svg>
            <span class="text-[10px] mt-1 font-medium">Daftar Hadir</span>
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
