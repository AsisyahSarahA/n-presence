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
        /* ========================================================
           SEMI-SKEUOMORPHISM DESIGN SYSTEM (TACTILE UI)
           Preserving Dark Navy (#1e3a5f) & Crisp White theme
           ======================================================== */

        /* Raised Tactile Card */
        .skeuo-card {
            background: linear-gradient(180deg, #ffffff 0%, #fafbfd 100%);
            border: 1px solid #e2e8f0;
            border-top: 1px solid #ffffff;
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 6px 18px -3px rgba(15, 23, 42, 0.06);
            border-radius: 1.25rem;
        }

        /* Stat Card (Raised with tactile hover response) */
        .skeuo-stat-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-top: 1px solid #ffffff;
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 4px 12px -2px rgba(15, 23, 42, 0.05);
            border-radius: 1.25rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .skeuo-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 4px 8px rgba(0, 0, 0, 0.05),
                0 12px 24px -4px rgba(15, 23, 42, 0.09);
        }

        /* Inset Recessed Well (Carved Surface) */
        .skeuo-inset {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.05),
                inset 0 1px 2px rgba(0, 0, 0, 0.04),
                0 1px 0 #ffffff;
            border-radius: 0.875rem;
        }

        /* Tactile Input Fields */
        .skeuo-input {
            display: block;
            width: 100%;
            height: 2.75rem; /* 44px standard tactile height */
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem; /* 14px text-sm */
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
        .skeuo-input:focus {
            background: #ffffff;
            border-color: #1e3a5f;
            box-shadow: 
                inset 0 1px 2px rgba(0, 0, 0, 0.03),
                0 0 0 3px rgba(30, 58, 95, 0.18),
                0 1px 2px rgba(0, 0, 0, 0.05);
            outline: none;
        }
        select.skeuo-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 8l3 3 3-3'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem 1.25rem;
            padding-right: 2.5rem;
        }
        textarea.skeuo-input {
            height: auto;
            min-height: 5.5rem;
        }
        input[type="file"].skeuo-input {
            height: 2.75rem;
            padding: 0.375rem 0.5rem;
            display: flex;
            align-items: center;
        }
        input[type="time"].skeuo-input,
        input[type="date"].skeuo-input {
            min-height: 2.75rem;
        }

        /* Tactile 3D Buttons (Push-Button Click Effect) */
        .skeuo-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 2.75rem; /* 44px uniform tactile height */
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

        /* 3D Primary Button (Dark Navy #1e3a5f) */
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
        .skeuo-btn-primary:hover {
            background: linear-gradient(180deg, #2e588f 0%, #1c365a 100%);
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.38),
                0 4px 8px rgba(19, 38, 64, 0.25);
        }
        .skeuo-btn-primary:active {
            border-bottom-width: 1px;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.4),
                0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* 3D Secondary Button (Vibrant Blue #3b82f6) */
        .skeuo-btn-secondary {
            background: linear-gradient(180deg, #4f9cf9 0%, #2563eb 100%);
            border: 1px solid #1d4ed8;
            border-bottom: 3px solid #1e40af;
            color: #ffffff;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.35),
                0 2px 4px rgba(37, 99, 235, 0.25);
            border-radius: 0.75rem;
        }
        .skeuo-btn-secondary:hover {
            background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%);
        }
        .skeuo-btn-secondary:active {
            border-bottom-width: 1px;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.3),
                0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* 3D Success Button (Emerald #10b981) */
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
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.3),
                0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* 3D Danger Button (Rose/Red #ef4444) */
        .skeuo-btn-danger {
            background: linear-gradient(180deg, #f87171 0%, #dc2626 100%);
            border: 1px solid #b91c1c;
            border-bottom: 3px solid #991b1b;
            color: #ffffff;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                0 2px 4px rgba(220, 38, 38, 0.25);
            border-radius: 0.75rem;
        }
        .skeuo-btn-danger:active {
            border-bottom-width: 1px;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.3),
                0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* 3D Light / White Tactile Button */
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
        .skeuo-btn-light:hover {
            background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 100%);
            color: #0f172a;
        }
        .skeuo-btn-light:active {
            border-bottom-width: 1px;
            box-shadow: 
                inset 0 2px 3px rgba(0, 0, 0, 0.1),
                0 1px 1px rgba(0, 0, 0, 0.05);
        }

        /* Tactile Badge */
        .skeuo-badge {
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.6),
                0 1px 2px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        /* Pagination light mode */
        nav[aria-label="Pagination"] a, nav[aria-label="Pagination"] span {
            border-radius: 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            margin: 0 2px !important;
            box-shadow: inset 0 1px 0 #ffffff, 0 1px 2px rgba(0,0,0,0.05);
        }
        nav[aria-label="Pagination"] svg {
            width: 14px !important;
            height: 14px !important;
        }
    </style>
</head>
<body class="bg-slate-100/90 font-sans min-h-screen flex">
    
    <!-- Sidebar (Fixed / Sticky - Tactile Dark Navy Surface) -->
    <aside class="w-64 bg-gradient-to-b from-[#182e4b] to-[#0f1d30] text-slate-100 flex-shrink-0 flex flex-col justify-between hidden md:flex sticky top-0 h-screen overflow-y-auto z-30 border-r border-[#102034] shadow-2xl">
        <div>
            <!-- Sidebar Header with Tactile Bevel -->
            <div class="h-16 flex items-center px-5 border-b border-slate-700/60 shadow-[0_1px_0_rgba(255,255,255,0.05)] shrink-0">
                @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                    <img src="{{ asset($appLogo) }}" alt="{{ $appName ?? 'Logo' }}" class="w-9 h-9 object-contain mr-3 rounded-xl shadow-md bg-white/10 p-1 border border-white/20">
                @else
                    <div class="w-9 h-9 bg-secondary/20 text-secondary rounded-xl flex items-center justify-center mr-3 font-bold text-lg border border-secondary/40 shadow-inner">
                        {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                    </div>
                @endif
                <span class="text-lg font-bold tracking-wide text-white truncate drop-shadow-sm">{{ $appName ?? 'N-Presence' }}</span>
            </div>

            <nav class="mt-6 px-3 space-y-1.5">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-md shadow-blue-900/40 border-t border-white/25 border-b border-blue-900' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21.75h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Master Data Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('admin.academic-years.*') || request()->routeIs('admin.classes.*') || request()->routeIs('admin.students.*') || request()->routeIs('admin.qr-cards.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                        class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl transition-all text-slate-300 hover:bg-white/10 hover:text-white">
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
                    <div x-show="open" x-transition:enter="transition-all duration-200 ease-out" class="mt-1 space-y-1 pl-3 bg-black/20 p-1.5 rounded-xl border border-white/5">
                        <a href="{{ route('admin.academic-years.index') }}" 
                           class="flex items-center space-x-3 px-3.5 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.academic-years.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-sm border-t border-white/20' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M12 3v2.25m5.25-2.25V5.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Z" />
                            </svg>
                            <span>Tahun Ajaran</span>
                        </a>
                        <a href="{{ route('admin.classes.index') }}" 
                           class="flex items-center space-x-3 px-3.5 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.classes.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-sm border-t border-white/20' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                            <span>Kelas</span>
                        </a>
                        <a href="{{ route('admin.students.index') }}" 
                           class="flex items-center space-x-3 px-3.5 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.students.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-sm border-t border-white/20' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span>Siswa</span>
                        </a>
                        <a href="{{ route('admin.qr-cards.index') }}" 
                           class="flex items-center space-x-3 px-3.5 py-2 rounded-xl transition-all text-sm {{ request()->routeIs('admin.qr-cards.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-sm border-t border-white/20' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span>Kartu QR</span>
                        </a>
                    </div>
                </div>

                <!-- Laporan Absensi -->
                <a href="{{ route('admin.reports.daily') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-md shadow-blue-900/40 border-t border-white/25 border-b border-blue-900' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span>Laporan Absensi</span>
                </a>

                <!-- Manajemen Kehadiran Manual -->
                <a href="{{ route('admin.attendances.manual.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.attendances.manual.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-md shadow-blue-900/40 border-t border-white/25 border-b border-blue-900' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                    </svg>
                    <span>Kehadiran Manual</span>
                </a>

                <!-- Izin & Sakit -->
                <a href="{{ route('admin.permits.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.permits.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-md shadow-blue-900/40 border-t border-white/25 border-b border-blue-900' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    <span>Izin & Sakit</span>
                </a>

                <!-- Kelola User -->
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-md shadow-blue-900/40 border-t border-white/25 border-b border-blue-900' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <span>Kelola User</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-secondary to-blue-600 text-white font-semibold shadow-md shadow-blue-900/40 border-t border-white/25 border-b border-blue-900' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer & Watermark -->
        <div class="p-4 border-t border-slate-700/60 shadow-[0_-1px_0_rgba(255,255,255,0.05)] space-y-3 shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-slate-700/60 border border-white/10 rounded-xl flex items-center justify-center text-white font-semibold shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="text-sm min-w-0">
                    <p class="font-semibold text-white truncate drop-shadow-sm">{{ Auth::user()->name }}</p>
                    <p class="text-slate-400 text-xs">Administrator</p>
                </div>
            </div>

            <!-- Watermark Credit -->
            <div class="pt-2.5 border-t border-slate-700/40 text-[10px] text-slate-400 leading-snug">
                <span class="text-slate-400 block text-[9px] uppercase tracking-wider font-semibold">Dikembangkan Oleh:</span>
                <span class="text-slate-200 font-medium">KKN 02 2026 LP3I Desa Nangtang (Manajemen Informatika)</span>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Topbar Header (Tactile White Elevation) -->
        <header class="h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/90 flex items-center justify-between px-6 sticky top-0 z-20 shadow-[0_2px_4px_rgba(0,0,0,0.02),0_1px_0_#ffffff]">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                @yield('header_title', 'Dashboard')
            </h2>

            <div class="flex items-center space-x-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="skeuo-btn skeuo-btn-light px-3.5 py-1.5 text-xs font-bold text-slate-600 hover:text-red-600 flex items-center space-x-2 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Footer with Watermark -->
        <footer class="mt-auto px-6 py-4 border-t border-slate-200 bg-white/90 backdrop-blur-sm text-xs text-slate-500 shadow-[0_-1px_0_#ffffff]">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>{{ $appName ?? 'N-Presence' }} &copy; {{ date('Y') }}</span>
                <span class="font-medium text-slate-600 text-center sm:text-right">
                    Oleh <strong class="text-slate-800">KKN 02 2026 LP3I Desa Nangtang (Manajemen Informatika)</strong>
                </span>
            </div>
        </footer>
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
