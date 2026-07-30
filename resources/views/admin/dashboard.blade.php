@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header_title', 'Dashboard ')

@section('content')
<div class="space-y-6">
    
    <!-- Welcome Header & Quick Toolbar -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-6 rounded-3xl text-white shadow-xl relative overflow-hidden">
        <div class="z-10">
            <div class="inline-flex items-center px-3 py-1 bg-indigo-500/20 border border-indigo-400/30 rounded-full text-xs font-semibold text-indigo-300 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1.5 text-indigo-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">
                Pantau statistik kehadiran siswa secara real-time, aktivitas scan masuk/pulang, serta rekapitulasi harian sekolah.
            </p>
        </div>
        <div class="z-10 flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.reports.daily') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2.5 rounded-2xl text-xs font-bold transition-all backdrop-blur-md border border-white/15 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span>Cetak Jurnal Harian</span>
            </a>
            <button onclick="confirmFinalize()" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-2xl text-xs font-bold transition-all shadow-lg flex items-center space-x-2 border border-indigo-400/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                <span>Finalisasi Absen (Generate Alpa)</span>
            </button>
        </div>
    </div>

    <!-- Summary Cards Row -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Siswa -->
        <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mt-2">{{ $totalStudents }}</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Persentase Kehadiran: <span class="font-bold text-emerald-600">{{ $attendancePercentage }}%</span></p>
        </div>

        <!-- Hadir -->
        <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Hadir Tepat Waktu</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-emerald-700 mt-2">{{ $totalHadir }}</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Siswa Masuk Tepat</p>
        </div>

        <!-- Terlambat -->
        <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Terlambat</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-amber-600 mt-2">{{ $totalTerlambat }}</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Tercatat Jam Telat</p>
        </div>

        <!-- Izin / Sakit -->
        <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider">Izin & Sakit</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-indigo-700 mt-2">{{ $totalIzinSakit }}</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Dengan Surat/Izin</p>
        </div>

        <!-- Alpa -->
        <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">Alpa / Absen</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-rose-700 mt-2">{{ $totalAlpa }}</h3>
            <p class="text-[10px] text-slate-500 mt-0.5">Tanpa Keterangan</p>
        </div>
    </div>

    <!-- Charts & Activity Feed Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Live Recent Activity Feed (Left Column) -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <h3 class="text-sm font-bold text-slate-800">Aktivitas Scan Terkini</h3>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Hari Ini</span>
                </div>

                <div class="space-y-3">
                    @forelse($recentScans as $scan)
                        <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-100 transition-all hover:bg-slate-100/60">
                            <div class="flex items-center space-x-3">
                                @if($scan->student->photo_path)
                                    <img src="{{ asset('storage/' . $scan->student->photo_path) }}" alt="Foto" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($scan->student->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 line-clamp-1">{{ $scan->student->name }}</h4>
                                    <p class="text-[10px] text-slate-500 font-mono">Kelas {{ $scan->student->classRoom->name ?? '-' }} — {{ $scan->time_in }}</p>
                                </div>
                            </div>
                            <div>
                                @if($scan->status == 'Hadir')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">Hadir</span>
                                @elseif($scan->status == 'Terlambat')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800">+{{ $scan->late_duration_minutes }}m</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-indigo-100 text-indigo-800">{{ $scan->status }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">
                            Belum ada scan aktivitas hari ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Donut Chart & Line Chart (Right 2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Line Chart (Tren Kehadiran 7 Hari) -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800">Grafik Tren Kehadiran (7 Hari Terakhir)</h3>
                    <span class="text-[10px] font-semibold text-slate-400">Statistik Mingguan</span>
                </div>
                <div class="h-56 w-full">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <!-- Class Matrix Breakdown -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Persentase Kehadiran per Kelas Hari Ini</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($classSummaries as $cs)
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-800 mb-1">
                                <span>Kelas {{ $cs['name'] }}</span>
                                <span class="text-emerald-600">{{ $cs['percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $cs['percentage'] }}%"></div>
                            </div>
                            <p class="text-[9px] text-slate-400 mt-1 font-medium">{{ $cs['hadir'] }} / {{ $cs['total'] }} Siswa</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Late Students Table -->
    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-150 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm">Daftar Siswa Terlambat Hari Ini</h3>
            <span class="text-xs text-amber-600 font-bold bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                Total: {{ $totalTerlambat }} Siswa
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3.5 px-6">Nama Siswa</th>
                        <th class="py-3.5 px-6">Kelas</th>
                        <th class="py-3.5 px-6">Jam Masuk</th>
                        <th class="py-3.5 px-6">Durasi Keterlambatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($lateStudents as $late)
                        <tr class="hover:bg-slate-50/60 transition-all">
                            <td class="py-3.5 px-6 font-bold text-slate-900">{{ $late->student->name }}</td>
                            <td class="py-3.5 px-6">Kelas {{ $late->student->classRoom->name ?? '-' }}</td>
                            <td class="py-3.5 px-6 font-mono text-rose-600 font-bold">{{ $late->time_in }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    +{{ $late->late_duration_minutes }} Menit
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400">Tidak ada siswa yang terlambat hari ini. Luar biasa!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lateStudents->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $lateStudents->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Line Chart - Tren Kehadiran
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Hadir Tepat Waktu',
                    data: {!! json_encode($chartHadir) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Terlambat',
                    data: {!! json_encode($chartTerlambat) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { boxWidth: 12, font: { size: 11, weight: 'bold' } }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 10 } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 10 } },
                    grid: { display: false }
                }
            }
        }
    });

    // SweetAlert2 Finalisasi Konfirmasi
    function confirmFinalize() {
        Swal.fire({
            title: 'Tutup Absensi Hari Ini?',
            text: "Siswa aktif yang belum melakukan scan masuk hari ini akan otomatis ditandai sebagai ALPA oleh sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Finalisasi!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl border border-slate-100',
                title: 'font-bold text-slate-800 text-lg',
                htmlContainer: 'text-xs text-slate-500',
                confirmButton: 'rounded-xl text-xs px-4 py-2 font-bold',
                cancelButton: 'rounded-xl text-xs px-4 py-2 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses Finalisasi...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('{{ route("admin.dashboard.finalize") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#4f46e5',
                            customClass: {
                                popup: 'rounded-3xl',
                                confirmButton: 'rounded-xl'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Terjadi kegagalan komunikasi dengan server lokal.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                });
            }
        });
    }
</script>
@endsection
