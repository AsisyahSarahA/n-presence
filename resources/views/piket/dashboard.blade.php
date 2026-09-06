@extends('layouts.piket')

@section('title', 'Piket Dashboard')

@section('content')
<div class="space-y-5 max-w-lg mx-auto pb-6">

    <!-- Welcome Header Slab -->
    <div class="bg-gradient-to-br from-[#182e4b] via-primary to-[#0f1d30] rounded-3xl p-5 border-t border-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.25),0_10px_24px_-4px_rgba(15,23,42,0.35)] text-white">
        <div class="flex items-center justify-between">
            <div>
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 bg-emerald-400/20 text-emerald-300 text-[10px] font-black rounded-full border border-emerald-400/30 uppercase tracking-wider shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Petugas Piket</span>
                </span>
                <h1 class="text-xl font-black text-white mt-1.5 tracking-tight">Halo, {{ Auth::user()->name }}</h1>
                <p class="text-xs text-blue-200 mt-0.5 font-medium">{{ Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#0f1d30]/80 flex items-center justify-center text-blue-200 border border-white/15 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Live Counter Cards (Tactile 3D Cards) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        <!-- Hadir Tepat -->
        <div class="skeuo-stat-card p-4 !border-emerald-200/80 dark:!border-emerald-500/30">
            <div class="flex items-center justify-between text-emerald-600 dark:text-emerald-400 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider">Hadir Tepat</span>
                <div class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-950/50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $totalHadir }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 font-medium">Siswa Tepat Waktu</p>
        </div>

        <!-- Terlambat -->
        <div class="skeuo-stat-card p-4 !border-amber-200/80 dark:!border-amber-500/30">
            <div class="flex items-center justify-between text-amber-600 dark:text-amber-400 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider">Terlambat</span>
                <div class="w-6 h-6 rounded-lg bg-amber-100 dark:bg-amber-950/50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $totalTerlambat }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 font-medium">Tercatat Jam Telat</p>
        </div>

        <!-- Siswa Sudah Pulang -->
        <div class="skeuo-stat-card p-4 !border-purple-200/80 dark:!border-purple-500/30">
            <div class="flex items-center justify-between text-purple-600 dark:text-purple-300 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider">Sudah Pulang</span>
                <div class="w-6 h-6 rounded-lg bg-purple-100 dark:bg-purple-950/50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-purple-700 dark:text-purple-200 mt-1">{{ $totalSudahPulang }}</div>
            <p class="text-[10px] text-purple-600 dark:text-purple-400 mt-1 font-medium">Scan Pulang Berhasil</p>
        </div>

        <!-- Izin / Sakit -->
        <div class="skeuo-stat-card p-4 !border-blue-200/80 dark:!border-blue-500/30">
            <div class="flex items-center justify-between text-blue-600 dark:text-blue-400 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider">Izin & Sakit</span>
                <div class="w-6 h-6 rounded-lg bg-blue-100 dark:bg-blue-950/50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $totalIzinSakit }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 font-medium">Dispensasi Resmi</p>
        </div>

        <!-- Total Siswa -->
        <div class="skeuo-stat-card p-4 col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider">Total Siswa</span>
                <div class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $totalStudents }}</div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 font-medium">Siswa Terdaftar</p>
        </div>
    </div>

    <!-- Quick Action Launchers (Tactile 3D Buttons) -->
    <div class="space-y-2">
        <h3 class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wider px-1">Menu Utama Piket</h3>
        <div class="grid grid-cols-2 gap-3.5">
            <!-- Scan Masuk Launcher -->
            <a href="{{ route('piket.scanner') }}?mode=in" 
               class="bg-gradient-to-b from-blue-600 to-indigo-700 hover:from-blue-500 hover:to-indigo-600 active:translate-y-[2px] p-5 rounded-2xl text-white flex flex-col items-center justify-center text-center border-t border-white/25 border-b-[3px] border-indigo-900 shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_4px_12px_rgba(30,58,95,0.25)] transition-all select-none">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-2.5 shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </div>
                <span class="text-xs font-black uppercase tracking-wider">Scan Masuk</span>
                <span class="text-[10px] text-blue-100 font-semibold mt-0.5">Sesi Pagi Hari</span>
            </a>

            <!-- Scan Pulang Launcher -->
            <a href="{{ route('piket.scanner') }}?mode=out" 
               class="bg-gradient-to-b from-[#1e3a5f] to-[#0f1d30] hover:from-[#254774] hover:to-[#182e4b] active:translate-y-[2px] p-5 rounded-2xl text-white flex flex-col items-center justify-center text-center border-t border-t-white/25 border-b-[3px] border-b-black/60 shadow-[inset_0_1px_0_rgba(255,255,255,0.3),0_4px_12px_rgba(15,23,42,0.35)] transition-all select-none">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-2.5 shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                </div>
                <span class="text-xs font-black uppercase tracking-wider">Scan Pulang</span>
                <span class="text-[10px] text-blue-200 font-semibold mt-0.5">Mulai {{ $timeOutStart ?? '13:00' }} WIB</span>
            </a>
        </div>
    </div>

    <!-- Recent Scans Stream -->
    <div class="skeuo-card p-5">
        <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-200/80 dark:border-slate-700/50">
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider">Scan Presensi Terakhir</h3>
            </div>
            <span class="skeuo-badge px-2 py-0.5 text-[9px] font-mono font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">Live Sync</span>
        </div>

        <div class="space-y-2.5">
            @forelse($recentScans as $scan)
                <div class="flex items-center justify-between p-3 skeuo-inset rounded-2xl">
                    <div class="flex items-center space-x-3 min-w-0">
                        @if($scan->student->photo_path)
                            <img src="{{ asset('storage/' . $scan->student->photo_path) }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-600 shadow-sm">
                        @else
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-b from-white to-slate-100 dark:from-slate-800 dark:to-slate-900 text-slate-700 dark:text-white flex items-center justify-center font-black text-xs border border-slate-200 dark:border-slate-700 shadow-sm">
                                {{ strtoupper(substr($scan->student->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="text-xs font-black text-slate-800 dark:text-white truncate tracking-tight">{{ $scan->student->name }}</h4>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-mono font-semibold">Kelas {{ $scan->student->classRoom->name ?? '-' }} — {{ \Carbon\Carbon::parse($scan->time_in)->format('H:i') }}</p>
                        </div>
                    </div>
                    <div>
                        @if($scan->status == 'Hadir')
                            <span class="skeuo-badge px-2.5 py-1 text-[10px] font-black bg-emerald-50 text-emerald-800 border-emerald-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(16,185,129,0.15)]">Hadir</span>
                        @elseif($scan->status == 'Terlambat')
                            <span class="skeuo-badge px-2.5 py-1 text-[10px] font-black bg-amber-50 text-amber-800 border-amber-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)]">+{{ $scan->late_duration_minutes }}m</span>
                        @else
                            <span class="skeuo-badge px-2.5 py-1 text-[10px] font-black bg-blue-50 text-blue-800 border-blue-300">{{ $scan->status }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-xs text-slate-400 dark:text-slate-500 font-medium">
                    Belum ada siswa yang melakukan scan presensi hari ini.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
