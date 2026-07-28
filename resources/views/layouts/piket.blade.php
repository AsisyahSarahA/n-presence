<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Piket Dashboard') - N-Presence</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
        /* Light mode overrides */
        html:not(.dark) body {
            background: #f1f5f9;
            color: #1e293b;
        }
        html:not(.dark) header {
            background: #ffffff;
            border-color: #e2e8f0;
        }
        html:not(.dark) nav {
            background: #ffffff;
            border-color: #e2e8f0;
        }
        html:not(.dark) .bg-slate-800,
        html:not(.dark) .bg-slate-900 {
            background: #ffffff;
        }
        html:not(.dark) .bg-slate-950 {
            background: #f8fafc;
        }
        html:not(.dark) .text-slate-100,
        html:not(.dark) .text-white {
            color: #1e293b;
        }
        html:not(.dark) .text-slate-400,
        html:not(.dark) .text-slate-500 {
            color: #64748b;
        }
        html:not(.dark) .border-slate-700\/50,
        html:not(.dark) .border-slate-800 {
            border-color: #e2e8f0;
        }
        html:not(.dark) #reader {
            background-color: #e2e8f0;
        }
        html:not(.dark) #btn-mode-in {
            border-color: #bfdbfe;
        }
        html:not(.dark) #btn-mode-out {
            border-color: #e2e8f0;
        }
        html:not(.dark) .bg-accent\/10 {
            background: rgb(5 150 105 / 0.1);
        }
        html:not(.dark) .bg-red-500\/10 {
            background: rgb(239 68 68 / 0.1);
        }
        html:not(.dark) .bg-accent\/20,
        html:not(.dark) .bg-accent\/30 {
            background: rgb(5 150 105 / 0.15);
        }
        html:not(.dark) .shadow-2xl {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
        }
        html:not(.dark) .shadow-lg {
            box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.04);
        }
        html:not(.dark) .bg-slate-800\/40 {
            background: rgb(241 245 249 / 0.5);
        }
        html:not(.dark) .border-accent\/30 {
            border-color: rgb(5 150 105 / 0.3);
        }
        html:not(.dark) button:hover {
            filter: brightness(0.97);
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans min-h-screen flex flex-col justify-between pb-16">

    <!-- Topbar Header -->
    <header class="h-14 bg-slate-800 border-b border-slate-700/50 flex items-center justify-between px-4 sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <span class="text-base font-bold tracking-wide text-white">N-Presence</span>
            <span class="px-2 py-0.5 bg-accent/20 text-accent text-[10px] font-semibold rounded-full hidden sm:inline">Piket</span>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Dark/Light Toggle -->
            <button id="theme-toggle" class="text-slate-400 hover:text-slate-200 transition-all p-1.5 rounded-lg hover:bg-slate-700/50">
                <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>

            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs text-slate-400 hover:text-red-400 font-medium py-1 px-2.5 rounded-lg hover:bg-slate-700/50 transition-all flex items-center space-x-1">
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
    <nav class="fixed bottom-0 inset-x-0 bg-slate-800 border-t border-slate-700/50 h-16 flex items-center justify-around px-2 z-50 shadow-lg">

        <!-- Tab: Home/Dashboard -->
        <a href="{{ route('piket.dashboard') }}"
           class="flex flex-col items-center justify-center w-20 h-full transition-all {{ request()->routeIs('piket.dashboard') ? 'text-accent' : 'text-slate-400 hover:text-slate-200' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21.75h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h8.25" />
            </svg>
            <span class="text-[10px] mt-1 font-medium">Beranda</span>
        </a>

        <!-- Tab: Scan Masuk -->
        <a href="{{ route('piket.scanner') }}"
           class="flex flex-col items-center justify-center w-20 h-full transition-all {{ request()->routeIs('piket.scanner') ? 'text-accent' : 'text-slate-400 hover:text-slate-200' }}">
            <div class="relative flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
                <span class="absolute -top-1.5 -right-1 text-[8px] bg-accent text-white px-1 rounded-full font-bold">IN/OUT</span>
            </div>
            <span class="text-[10px] mt-1 font-medium">Scanner</span>
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

        // Theme Toggle
        (function() {
            const html = document.documentElement;
            const toggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            function setTheme(dark) {
                if (dark) {
                    html.classList.add('dark');
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    html.classList.remove('dark');
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
                localStorage.setItem('piket-theme', dark ? 'dark' : 'light');
            }

            // Apply saved theme
            const saved = localStorage.getItem('piket-theme');
            if (saved === 'light') {
                setTheme(false);
            } else {
                setTheme(true);
            }

            toggle.addEventListener('click', () => {
                setTheme(!html.classList.contains('dark'));
            });
        })();
    </script>
</body>
</html>
