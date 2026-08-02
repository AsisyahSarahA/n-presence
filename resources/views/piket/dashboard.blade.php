@extends('layouts.piket')

@section('title', 'Piket Dashboard')

@section('content')
<div class="space-y-5 max-w-lg mx-auto pb-6">

    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-50/60 to-indigo-50/80 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-950 rounded-3xl p-5 border border-indigo-100/80 dark:border-slate-700/50 shadow-sm dark:shadow-lg text-slate-800 dark:text-white">
        <div class="flex items-center justify-between">
            <div>
                <span class="px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-200 dark:border-emerald-400/30 uppercase tracking-wider">Petugas Piket</span>
                <h1 class="text-xl font-bold text-slate-800 dark:text-white mt-1">Halo, {{ Auth::user()->name }} 👋</h1>
                <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">{{ Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-indigo-100/50 dark:bg-white/10 flex items-center justify-center text-indigo-600 dark:text-white border border-indigo-200/50 dark:border-white/15">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Live Counter Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        <!-- Hadir Tepat -->
        <div class="bg-white dark:bg-slate-800/80 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm dark:shadow-md">
            <div class="flex items-center justify-between text-emerald-600 dark:text-emerald-400 mb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider">Hadir Tepat</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalHadir }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Siswa Pagi Ini</p>
        </div>

        <!-- Terlambat -->
        <div class="bg-white dark:bg-slate-800/80 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm dark:shadow-md">
            <div class="flex items-center justify-between text-amber-600 dark:text-amber-400 mb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider">Terlambat</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalTerlambat }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Tercatat Jam Telat</p>
        </div>

        <!-- Siswa Sudah Pulang -->
        <div class="bg-purple-50/90 dark:bg-purple-950/40 p-4 rounded-2xl border border-purple-200/80 dark:border-purple-800/50 shadow-sm dark:shadow-md">
            <div class="flex items-center justify-between text-purple-700 dark:text-purple-300 mb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider">Sudah Pulang</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </div>
            <div class="text-3xl font-extrabold text-purple-900 dark:text-purple-200">{{ $totalSudahPulang }}</div>
            <p class="text-[10px] text-purple-600 dark:text-purple-400 mt-1">Sudah Scan Pulang</p>
        </div>

        <!-- Izin / Sakit -->
        <div class="bg-white dark:bg-slate-800/80 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm dark:shadow-md">
            <div class="flex items-center justify-between text-indigo-600 dark:text-indigo-400 mb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider">Izin & Sakit</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalIzinSakit }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Siswa Ber-Surat</p>
        </div>

        <!-- Total Siswa -->
        <div class="bg-white dark:bg-slate-800/80 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm dark:shadow-md col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 mb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider">Total Siswa</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <div class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalStudents }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Target Absensi</p>
        </div>
    </div>

    <!-- Quick Action Launchers -->
    <div class="space-y-2">
        <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider px-1">Menu Utama Piket</h3>
        <div class="grid grid-cols-2 gap-3">
            <!-- Scan Masuk Launcher -->
            <a href="{{ route('piket.scanner') }}?mode=in" class="bg-gradient-to-br from-blue-600 to-indigo-700 hover:from-blue-500 hover:to-indigo-600 p-4 rounded-2xl text-white flex flex-col items-center justify-center text-center shadow-md hover:shadow-lg transition-all border border-blue-400/30">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider">Scan Masuk</span>
                <span class="text-[9px] text-blue-100 mt-0.5">Pagi Hari</span>
            </a>

            <!-- Scan Pulang Launcher -->
            <a href="{{ route('piket.scanner') }}?mode=out" class="bg-gradient-to-br from-purple-600 to-pink-700 hover:from-purple-500 hover:to-pink-600 p-4 rounded-2xl text-white flex flex-col items-center justify-center text-center shadow-md hover:shadow-lg transition-all border border-purple-400/30">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider">Scan Pulang</span>
                <span class="text-[9px] text-purple-100 mt-0.5">Siang Hari</span>
            </a>
        </div>
    </div>

    <!-- Recent Scans Stream -->
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-5 border border-slate-100 dark:border-slate-700/50 shadow-sm dark:shadow-md">
        <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100 dark:border-slate-700/50">
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                <h3 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Scan Presensi Terakhir</h3>
            </div>
            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">Live Sync</span>
        </div>

        <div class="space-y-2.5">
            @forelse($recentScans as $scan)
                <div class="flex items-center justify-between p-2.5 bg-slate-50 dark:bg-slate-900/60 rounded-2xl border border-slate-100 dark:border-slate-700/40">
                    <div class="flex items-center space-x-3 min-w-0">
                        @if($scan->student->photo_path)
                            <img src="{{ asset('storage/' . $scan->student->photo_path) }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 dark:border-slate-600">
                        @else
                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($scan->student->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ $scan->student->name }}</h4>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Kelas {{ $scan->student->classRoom->name ?? '-' }} — {{ \Carbon\Carbon::parse($scan->time_in)->format('H:i') }}</p>
                        </div>
                    </div>
                    <div>
                        @if($scan->status == 'Hadir')
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30">Hadir</span>
                        @elseif($scan->status == 'Terlambat')
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-amber-50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30">+{{ $scan->late_duration_minutes }}m</span>
                        @else
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/30">{{ $scan->status }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-xs text-slate-400 dark:text-slate-500">
                    Belum ada siswa yang melakukan scan presensi hari ini.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
