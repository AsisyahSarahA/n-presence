@extends('layouts.piket')

@section('title', 'Daftar Hadir Hari Ini')

@section('content')
<!-- Auto Refresh 30 Detik untuk Guru Piket -->
<meta http-equiv="refresh" content="30">

<div class="space-y-5 max-w-4xl mx-auto pb-8">

    <!-- Top Navigation & Live Status Header Slab -->
    <div class="bg-gradient-to-br from-[#182e4b] via-primary to-[#0f1d30] rounded-3xl p-5 text-white border-t border-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.25),0_10px_24px_-4px_rgba(15,23,42,0.35)] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-[10px] font-black uppercase tracking-widest text-emerald-300 mb-1.5 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Live Auto-Sync (30s)</span>
            </div>
            <h1 class="text-xl font-black tracking-tight text-white drop-shadow-sm">Daftar Kehadiran Siswa Hari Ini</h1>
            <p class="text-xs text-blue-200 mt-0.5 font-medium">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="flex items-center space-x-2 shrink-0">
            <a href="{{ route('piket.scanner') }}" class="skeuo-btn skeuo-btn-success text-xs py-2 px-4 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                </svg>
                <span>Buka Scanner</span>
            </a>
        </div>
    </div>

    <!-- Live Counter Badges (Tactile 3D Stat Cards) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <!-- Total Scanned -->
        <div class="skeuo-stat-card p-4 text-center">
            <div class="text-[10px] font-black uppercase tracking-wider text-slate-500">Total Scan Hari Ini</div>
            <div class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $summary['total_scanned'] }}</div>
        </div>

        <!-- Hadir Tepat -->
        <div class="skeuo-stat-card p-4 text-center !border-emerald-200/80 dark:!border-emerald-500/30">
            <div class="text-[10px] font-black uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Hadir Tepat</div>
            <div class="text-2xl font-black text-emerald-700 dark:text-emerald-300 mt-1">{{ $summary['hadir'] }}</div>
        </div>

        <!-- Terlambat -->
        <div class="skeuo-stat-card p-4 text-center !border-amber-200/80 dark:!border-amber-500/30">
            <div class="text-[10px] font-black uppercase tracking-wider text-amber-600 dark:text-amber-400">Terlambat</div>
            <div class="text-2xl font-black text-amber-700 dark:text-amber-300 mt-1">{{ $summary['terlambat'] }}</div>
        </div>

        <!-- Sudah Pulang -->
        <div class="skeuo-stat-card p-4 text-center !border-purple-200/80 dark:!border-purple-500/30">
            <div class="text-[10px] font-black uppercase tracking-wider text-purple-600 dark:text-purple-400">Sudah Scan Pulang</div>
            <div class="text-2xl font-black text-purple-700 dark:text-purple-300 mt-1">{{ $summary['sudah_pulang'] }}</div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="skeuo-card p-4">
        <form method="GET" action="{{ route('piket.today') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NISN Siswa..."
                    class="skeuo-input text-xs font-semibold text-slate-800 dark:text-white">
            </div>
            <div>
                <select name="class_id" class="skeuo-input text-xs font-semibold text-slate-800 dark:text-white">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="skeuo-btn skeuo-btn-primary w-full text-xs py-2">
                    Filter Data
                </button>
                @if(request()->hasAny(['search', 'class_id']))
                    <a href="{{ route('piket.today') }}" class="skeuo-btn skeuo-btn-light text-xs py-2 px-3 shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Attendance History Table Card -->
    <div class="skeuo-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/80 dark:border-slate-700 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-900">
            <h3 class="font-black text-slate-800 dark:text-white text-sm tracking-tight">Daftar Aktivitas Scan Hari Ini</h3>
            <span class="skeuo-badge px-2.5 py-0.5 text-[10px] text-slate-500 dark:text-slate-300 font-mono font-bold">Auto-refresh 30s</span>
        </div>

        <div id="table-container" class="relative">
            @include('piket.partials._today_table')
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('table-container');
        if (!container) return;

        // Helper: tampilkan overlay loading
        function showLoading() {
            container.classList.add('opacity-40', 'pointer-events-none');
            let overlay = container.querySelector('.table-loading-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'table-loading-overlay absolute inset-0 z-10 flex items-center justify-center bg-slate-50/70 dark:bg-slate-900/70 rounded-b-3xl transition-opacity';
                overlay.innerHTML = `
                    <div class="flex items-center space-x-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-full shadow-lg border border-slate-200 dark:border-slate-700">
                        <svg class="animate-spin w-4 h-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">Memuat halaman...</span>
                    </div>`;
                container.appendChild(overlay);
            }
            overlay.classList.remove('hidden');
        }

        function hideLoading() {
            container.classList.remove('opacity-40', 'pointer-events-none');
            const overlay = container.querySelector('.table-loading-overlay');
            if (overlay) overlay.classList.add('hidden');
        }

        // Fetch konten tabel dari URL
        function fetchTable(url) {
            showLoading();
            return fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                container.innerHTML = html;
                // Perbarui URL tanpa reload agar tombol Back di HP tetap berfungsi
                window.history.pushState({}, '', url);
            })
            .finally(() => hideLoading());
        }

        // Delegasi klik pada link pagination di dalam #table-container
        container.addEventListener('click', function (e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const url = new URL(link.href);
            if (!url.searchParams.has('page')) return;

            e.preventDefault();
            fetchTable(link.href).catch(() => {
                // Fallback: jika gagal, lakukan navigasi penuh
                window.location.href = link.href;
            });
        });

        // Tangani tombol Back / Forward browser (popstate)
        window.addEventListener('popstate', function () {
            fetchTable(window.location.href).catch(() => window.location.reload());
        });
    });
</script>
@endpush
