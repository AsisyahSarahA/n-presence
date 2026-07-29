<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - {{ $appName ?? 'N-Presence' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a5f',
                        secondary: '#3b82f6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Pagination light mode */
        nav[aria-label="Pagination"] a, nav[aria-label="Pagination"] span {
            border-radius: 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            margin: 0 2px !important;
        }
        nav[aria-label="Pagination"] svg {
            width: 14px !important;
            height: 14px !important;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-slate-100 flex-shrink-0 flex-col justify-between hidden md:flex">
        <div>
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-5 border-b border-slate-700/50">
                @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                    <img src="{{ asset($appLogo) }}" alt="{{ $appName ?? 'Logo' }}" class="w-9 h-9 object-contain mr-3 rounded-lg shadow-sm bg-white/10 p-0.5">
                @else
                    <div class="w-9 h-9 bg-secondary/20 text-secondary rounded-lg flex items-center justify-center mr-3 font-bold text-lg border border-secondary/30">
                        {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                    </div>
                @endif
                <span class="text-lg font-bold tracking-wide text-white truncate">{{ $appName ?? 'N-Presence' }}</span>
            </div>

            <nav class="mt-6 px-4 space-y-1.5">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-secondary text-white font-medium shadow-md shadow-secondary/20' : 'text-slate-300 hover:bg-[#2a4a7f] hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21.75h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Master Data Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('admin.academic-years.*') || request()->routeIs('admin.classes.*') || request()->routeIs('admin.students.*') || request()->routeIs('admin.qr-cards.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                        class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl transition-all text-slate-300 hover:bg-[#2a4a7f] hover:text-white">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A5.998 5.998 0 0 1 1.228 6.75 12.06 12.06 0 0 1 12 3c3.78 0 7.21 1.74 9.518 4.5a5.998 5.998 0 0 1-2.658 2.584m-15.482 0A50.584 50.584 0 0 1 12 13.713a50.58 50.58 0 0 1 8.232-3.566m0 0v-1.14" />
                            </svg>
                            <span class="text-sm font-medium">Master Data</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 transition-transform duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition-all duration-200 ease-out" class="mt-1 space-y-1 pl-4">
                        <a href="{{ route('admin.academic-years.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.academic-years.*') ? 'bg-secondary text-white font-medium' : 'text-slate-400 hover:bg-[#2a4a7f] hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M12 3v2.25m5.25-2.25V5.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Z" />
                            </svg>
                            <span>Tahun Ajaran</span>
                        </a>
                        <a href="{{ route('admin.classes.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.classes.*') ? 'bg-secondary text-white font-medium' : 'text-slate-400 hover:bg-[#2a4a7f] hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                            <span>Kelas</span>
                        </a>
                        <a href="{{ route('admin.students.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.students.*') ? 'bg-secondary text-white font-medium' : 'text-slate-400 hover:bg-[#2a4a7f] hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span>Siswa</span>
                        </a>
                        <a href="{{ route('admin.qr-cards.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.qr-cards.*') ? 'bg-secondary text-white font-medium' : 'text-slate-400 hover:bg-[#2a4a7f] hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span>Kartu QR</span>
                        </a>
                    </div>
                </div>

                <!-- Laporan Absensi -->
                <a href="{{ route('admin.reports.daily') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-secondary text-white font-medium shadow-md shadow-secondary/20' : 'text-slate-300 hover:bg-[#2a4a7f] hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span>Laporan Absensi</span>
                </a>

                <!-- Manajemen Kehadiran Manual -->
                <a href="{{ route('admin.attendances.manual.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.attendances.manual.*') ? 'bg-secondary text-white font-medium shadow-md shadow-secondary/20' : 'text-slate-300 hover:bg-[#2a4a7f] hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                    </svg>
                    <span>Kehadiran Manual</span>
                </a>

                <!-- Izin & Sakit -->
                <a href="{{ route('admin.permits.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.permits.*') ? 'bg-secondary text-white font-medium shadow-md shadow-secondary/20' : 'text-slate-300 hover:bg-[#2a4a7f] hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    <span>Izin & Sakit</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-secondary text-white font-medium shadow-md shadow-secondary/20' : 'text-slate-300 hover:bg-[#2a4a7f] hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-700/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-slate-700/50 rounded-full flex items-center justify-center text-white font-semibold">
                        A
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-slate-400 text-xs">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Topbar Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800">
                @yield('header_title', 'Dashboard')
            </h2>

            <div class="flex items-center space-x-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-sm text-slate-600 hover:text-red-600 transition-all font-medium py-1.5 px-3 rounded-lg hover:bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>

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
    </script>

    @yield('scripts')
</body>
</html>
