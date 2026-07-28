@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- Welcome Header & Finalize Button -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau data kehadiran siswa secara real-time hari ini.</p>
        </div>
        <div>
            <button onclick="confirmFinalize()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                <span>Finalisasi Absen (Generate Alpa)</span>
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Siswa -->
        <div class="bg-blue-50/70 border border-blue-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-blue-600 block uppercase tracking-wider">Total Siswa</span>
                <span class="text-3xl font-extrabold text-blue-900 block mt-1">{{ $totalStudents }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
        </div>

        <!-- Hadir -->
        <div class="bg-emerald-50/70 border border-emerald-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-emerald-600 block uppercase tracking-wider">Hadir</span>
                <span class="text-3xl font-extrabold text-emerald-900 block mt-1">{{ $totalHadir }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="bg-amber-50/70 border border-amber-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-amber-600 block uppercase tracking-wider">Terlambat</span>
                <span class="text-3xl font-extrabold text-amber-900 block mt-1">{{ $totalTerlambat }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>

        <!-- Alpa / Tidak Hadir -->
        <div class="bg-rose-50/70 border border-rose-100 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-rose-600 block uppercase tracking-wider">Alpa / Absen</span>
                <span class="text-3xl font-extrabold text-rose-900 block mt-1">{{ $totalAlpa }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Donut Chart (Persentase Kehadiran) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center">
            <h3 class="text-sm font-bold text-slate-800 w-full text-left mb-4">Persentase Kehadiran Hari Ini</h3>
            <div class="relative w-full max-w-[200px]">
                <canvas id="donutChart"></canvas>
            </div>
        </div>

        <!-- Line Chart (Tren Kehadiran) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm lg:col-span-2 flex flex-col">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Tren Kehadiran (7 Hari Terakhir)</h3>
            <div class="flex-1 w-full min-h-[220px]">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Late List Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-150">
            <h3 class="font-bold text-slate-800 text-sm">Siswa Terlambat Hari Ini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-6">Nama Siswa</th>
                        <th class="py-3.5 px-6">Kelas</th>
                        <th class="py-3.5 px-6">Jam Masuk</th>
                        <th class="py-3.5 px-6">Durasi Telat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lateStudents as $late)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="py-3.5 px-6 font-semibold text-slate-900">{{ $late->student->name }}</td>
                            <td class="py-3.5 px-6">{{ $late->student->classRoom->name }}</td>
                            <td class="py-3.5 px-6 font-mono text-red-600">{{ $late->time_in }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                    {{ $late->late_duration_minutes }} Menit
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400">Hari ini tidak ada siswa terlambat. Bagus sekali!</td>
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
    // 1. Donut Chart - Persentase Kehadiran
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    const donutChart = new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Terlambat', 'Alpa'],
            datasets: [{
                data: [{{ $totalHadir }}, {{ $totalTerlambat }}, {{ $totalAlpa }}],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, font: { size: 10 } }
                }
            },
            cutout: '70%'
        }
    });

    // 2. Line Chart - Tren Kehadiran
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
                    backgroundColor: '#e6f4ea',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Terlambat',
                    data: {!! json_encode($chartTerlambat) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: '#fef7e0',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, font: { size: 10 } }
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

    // 3. SweetAlert2 Finalisasi Konfirmasi (Cerdas & Komunikatif)
    function confirmFinalize() {
        Swal.fire({
            title: 'Tutup Absensi Hari Ini?',
            text: "Siswa aktif yang belum melakukan scan masuk hari ini akan otomatis ditandai sebagai ALPA oleh sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5', // Indigo-600
            cancelButtonColor: '#94a3b8', // Slate-400
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
                // Show Loading
                Swal.fire({
                    title: 'Memproses Finalisasi...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Hit AJAX Finalize API
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
                            window.location.reload(); // Reload dashboard untuk update grafik
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
