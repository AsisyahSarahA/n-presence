@extends('layouts.piket')

@section('title', 'Piket Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700/50">
        <h1 class="text-xl font-bold text-white">Halo, {{ Auth::user()->name }}</h1>
        <p class="text-xs text-slate-400 mt-1">Petugas Piket Hari Ini: {{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <!-- Live Attendance Counter -->
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700/50 text-center shadow-lg">
        <div class="text-sm text-slate-400 font-medium">Siswa Hadir Hari Ini</div>
        <div class="text-5xl font-extrabold text-accent my-3">0</div>
        <div class="text-xs text-slate-500">Menunggu scan kartu pertama...</div>
    </div>

    <!-- Scan Modes (Quick Shortcuts) -->
    <div class="grid grid-cols-2 gap-4">
        <a href="#" class="bg-slate-800 hover:bg-slate-750 p-5 rounded-2xl border border-slate-700/50 flex flex-col items-center justify-center text-center group transition-all">
            <div class="w-12 h-12 bg-accent/10 text-accent rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                </svg>
            </div>
            <span class="text-sm font-semibold text-white">Scan Masuk</span>
        </a>

        <a href="#" class="bg-slate-800 hover:bg-slate-750 p-5 rounded-2xl border border-slate-700/50 flex flex-col items-center justify-center text-center group transition-all">
            <div class="w-12 h-12 bg-red-500/10 text-red-400 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                </svg>
            </div>
            <span class="text-sm font-semibold text-white">Scan Pulang</span>
        </a>
    </div>
</div>
@endsection
