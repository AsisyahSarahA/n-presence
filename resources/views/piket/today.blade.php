@extends('layouts.piket')

@section('title', 'Daftar Hadir Hari Ini')

@section('content')
<!-- Auto Refresh 30 Detik untuk Guru Piket -->
<meta http-equiv="refresh" content="30">

<div class="space-y-5 max-w-4xl mx-auto pb-8">

    <!-- Top Navigation & Live Status Header -->
    <div class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 rounded-3xl p-5 text-white shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 mb-1">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-300">Live Auto-Sync (30s)</span>
            </div>
            <h1 class="text-xl font-bold tracking-wide">Daftar Kehadiran Siswa Hari Ini</h1>
            <p class="text-xs text-slate-300 mt-0.5">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="flex items-center space-x-2 shrink-0">
            <a href="{{ route('piket.scanner') }}" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl text-xs font-bold transition-all shadow-md flex items-center space-x-1.5 border border-emerald-400/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                </svg>
                <span>Buka Scanner</span>
            </a>
        </div>
    </div>

    <!-- Live Counter Badges (Soft Pastel Theme) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <!-- Total Scanned -->
        <div class="bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/60 p-4 rounded-2xl shadow-sm text-center">
            <div class="text-[10px] font-bold uppercase text-slate-400">Total Scan Hari Ini</div>
            <div class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $summary['total_scanned'] }}</div>
        </div>

        <!-- Hadir Tepat -->
        <div class="bg-emerald-50/80 dark:bg-emerald-950/30 border border-emerald-200/80 dark:border-emerald-800/40 p-4 rounded-2xl shadow-sm text-center">
            <div class="text-[10px] font-bold uppercase text-emerald-600 dark:text-emerald-400">Hadir Tepat</div>
            <div class="text-2xl font-black text-emerald-700 dark:text-emerald-300 mt-1">{{ $summary['hadir'] }}</div>
        </div>

        <!-- Terlambat -->
        <div class="bg-amber-50/80 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/40 p-4 rounded-2xl shadow-sm text-center">
            <div class="text-[10px] font-bold uppercase text-amber-600 dark:text-amber-400">Terlambat</div>
            <div class="text-2xl font-black text-amber-700 dark:text-amber-300 mt-1">{{ $summary['terlambat'] }}</div>
        </div>

        <!-- Sudah Pulang -->
        <div class="bg-sky-50/80 dark:bg-sky-950/30 border border-sky-200/80 dark:border-sky-800/40 p-4 rounded-2xl shadow-sm text-center">
            <div class="text-[10px] font-bold uppercase text-sky-600 dark:text-sky-400">Sudah Scan Pulang</div>
            <div class="text-2xl font-black text-sky-700 dark:text-sky-300 mt-1">{{ $summary['sudah_pulang'] }}</div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/60 p-4 rounded-3xl shadow-sm">
        <form method="GET" action="{{ route('piket.today') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NISN Siswa..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-medium text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <select name="class_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-medium text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                    Filter Data
                </button>
                @if(request()->hasAny(['search', 'class_id']))
                    <a href="{{ route('piket.today') }}" class="px-3 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-200 transition-all shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Attendance History Table -->
    <div class="bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/60 rounded-3xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 dark:text-white text-sm">Daftar Aktivitas Scan Hari Ini</h3>
            <span class="text-[10px] text-slate-400 font-mono">Halaman ini otomatis ter-refresh setiap 30 detik</span>
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
