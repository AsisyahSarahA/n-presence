@extends('layouts.app')

@section('title', 'Laporan Absensi')
@section('header_title', 'Laporan & Rekapitulasi Presensi')

@section('content')
<div class="space-y-6" x-data="{ activeTab: '{{ $tab }}' }">

    <!-- Header Banner (Tactile Dark Navy Slab) -->
    <div class="bg-gradient-to-br from-[#182e4b] via-[#1e3a5f] to-[#0f1d30] rounded-3xl p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4 border border-[#1e3a5f] border-t-white/25 shadow-blue-950/20">
        <div>
            <h2 class="text-xl font-bold tracking-wide drop-shadow-sm">Pusat Laporan Absensi Siswa</h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">
                Cetak dan ekspor Laporan Harian, Rekapitulasi Bulanan, serta Rekapitulasi Raport Semester resmi siap guna untuk keperluan administrasi sekolah.
            </p>
        </div>
        <div class="flex items-center space-x-2 shrink-0">
            <span class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-white/10 border border-white/15 rounded-xl text-xs font-semibold text-slate-200 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
                <span>{{ $schoolName }}</span>
            </span>
        </div>
    </div>

    <!-- Tabbed Navigation Bar (Physical Switch Deck) -->
    <div class="skeuo-card overflow-hidden">
        <div class="p-3 bg-slate-100 border-b border-slate-200/80 shadow-inner">
            <div class="flex space-x-2 overflow-x-auto p-1 bg-slate-200/60 rounded-2xl border border-slate-300/60 shadow-inner">
                <button @click="activeTab = 'daily'"
                    :class="activeTab === 'daily' ? 'bg-white text-primary font-bold shadow-md shadow-slate-300/50 border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center space-x-2 shrink-0 skeuo-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M12 3v2.25m5.25-2.25V5.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Z" />
                    </svg>
                    <span>1. Laporan Harian</span>
                </button>

                <button @click="activeTab = 'monthly'"
                    :class="activeTab === 'monthly' ? 'bg-white text-primary font-bold shadow-md shadow-slate-300/50 border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center space-x-2 shrink-0 skeuo-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    <span>2. Rekapitulasi Bulanan</span>
                </button>

                <button @click="activeTab = 'semester'"
                    :class="activeTab === 'semester' ? 'bg-white text-primary font-bold shadow-md shadow-slate-300/50 border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                    class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center space-x-2 shrink-0 skeuo-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-11.25 0H4.5A2.25 2.25 0 0 1 2.25 16.5V6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 0 1 1.123-.08m0 0A2.251 2.251 0 0 1 7.5 2.25H9c1.012 0 1.867.668 2.15 1.586M9 12h6m-6 3h6m-6 3h3" />
                    </svg>
                    <span>3. Rekap Raport Semester</span>
                </button>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 1: LAPORAN HARIAN -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'daily'" class="p-6 space-y-6">
            <!-- Filter Bar Daily (Tactile Inset Well) -->
            <form method="GET" action="{{ route('admin.reports.daily') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end skeuo-inset p-5 rounded-2xl">
                <input type="hidden" name="tab" value="daily">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="daily_date" value="{{ $dailyDate }}" required
                        class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas</label>
                    <select name="daily_class_id" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ $dailyClassId == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="skeuo-btn skeuo-btn-primary w-full h-11 py-2.5 text-xs sm:text-sm font-bold shadow-md">
                        Filter Daily
                    </button>
                    @if($dailyClassId)
                        <a href="{{ route('admin.reports.print_daily', ['date' => $dailyDate, 'class_id' => $dailyClassId]) }}" target="_blank"
                            class="skeuo-btn skeuo-btn-secondary h-11 px-4 py-2.5 text-xs sm:text-sm font-bold shrink-0 flex items-center space-x-1.5 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak Laporan</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Summary Cards Daily (Tactile Stat Cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
                <div class="skeuo-stat-card p-3.5 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa</div>
                    <div class="text-xl font-extrabold text-slate-800 mt-1">{{ $dailySummary['total'] }}</div>
                </div>
                <div class="skeuo-stat-card p-3.5 text-center bg-emerald-50/50 border-emerald-200/80">
                    <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Hadir</div>
                    <div class="text-xl font-extrabold text-emerald-700 mt-1">{{ $dailySummary['hadir'] }}</div>
                </div>
                <div class="skeuo-stat-card p-3.5 text-center bg-amber-50/50 border-amber-200/80">
                    <div class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Terlambat</div>
                    <div class="text-xl font-extrabold text-amber-700 mt-1">{{ $dailySummary['terlambat'] }}</div>
                </div>
                <div class="skeuo-stat-card p-3.5 text-center bg-purple-50/50 border-purple-200/80">
                    <div class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Sudah Pulang</div>
                    <div class="text-xl font-extrabold text-purple-700 mt-1">{{ $dailySummary['sudah_pulang'] ?? 0 }}</div>
                </div>
                <div class="skeuo-stat-card p-3.5 text-center bg-blue-50/50 border-blue-200/80">
                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Izin</div>
                    <div class="text-xl font-extrabold text-blue-700 mt-1">{{ $dailySummary['izin'] }}</div>
                </div>
                <div class="skeuo-stat-card p-3.5 text-center bg-orange-50/50 border-orange-200/80">
                    <div class="text-[10px] font-bold text-orange-600 uppercase tracking-wider">Sakit</div>
                    <div class="text-xl font-extrabold text-orange-700 mt-1">{{ $dailySummary['sakit'] }}</div>
                </div>
                <div class="skeuo-stat-card p-3.5 text-center bg-rose-50/50 border-rose-200/80">
                    <div class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">Alpha</div>
                    <div class="text-xl font-extrabold text-rose-700 mt-1">{{ $dailySummary['alpa'] }}</div>
                </div>
            </div>

            <!-- Table Daily -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center">No</th>
                            <th class="py-3 px-4">NISN & Nama Siswa</th>
                            <th class="py-3 px-4 text-center">Status Laporan</th>
                            <th class="py-3 px-4 text-center">Jam Masuk</th>
                            <th class="py-3 px-4 text-center">Jam Pulang</th>
                            <th class="py-3 px-4 text-center">Terlambat</th>
                            <th class="py-3 px-4">Catatan / Alasan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($dailyAttendances as $idx => $att)
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="py-3 px-4 text-center font-mono text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $att->student->name ?? '-' }}</div>
                                    <div class="text-[10px] font-mono text-slate-400">NISN: {{ $att->student->nisn ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @php
                                        $effStatus = $att->effective_status;
                                        $bCol = match($effStatus) {
                                            'Hadir' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'Terlambat' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'Izin' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'Sakit' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            default => 'bg-red-100 text-red-800 border-red-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $bCol }}">
                                        {{ $effStatus }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-mono font-semibold">
                                    {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('H:i:s') : '-' }}
                                </td>
                                <td class="py-3 px-4 text-center font-mono font-semibold">
                                    @if($att->time_out)
                                        <span class="text-emerald-700">{{ \Carbon\Carbon::parse($att->time_out)->format('H:i:s') }}</span>
                                    @else
                                        <span class="text-rose-500 font-normal italic">Belum Pulang</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center font-semibold text-amber-700">
                                    {{ $att->late_duration_minutes > 0 ? $att->late_duration_minutes . ' menit' : '-' }}
                                </td>
                                <td class="py-3 px-4 text-slate-600 max-w-xs truncate">
                                    {{ $att->notes ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 text-sm">
                                    Belum ada data presensi pada tanggal dan kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 2: REKAPITULASI BULANAN -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'monthly'" class="p-6 space-y-6">
            <!-- Filter Bar Monthly (Tactile Inset Well) -->
            <form method="GET" action="{{ route('admin.reports.daily') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end skeuo-inset p-5 rounded-2xl">
                <input type="hidden" name="tab" value="monthly">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bulan</label>
                    <select name="monthly_month" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $monthlyMonth == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun</label>
                    <select name="monthly_year" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        @foreach(range(now()->year - 2, now()->year + 1) as $y)
                            <option value="{{ $y }}" {{ $monthlyYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas</label>
                    <select name="monthly_class_id" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ $monthlyClassId == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="skeuo-btn skeuo-btn-primary w-full h-11 py-2.5 text-xs sm:text-sm font-bold shadow-md">
                        Filter Bulanan
                    </button>
                    @if($monthlyClassId)
                        <a href="{{ route('admin.reports.print_monthly', ['month' => $monthlyMonth, 'year' => $monthlyYear, 'class_id' => $monthlyClassId]) }}" target="_blank"
                            class="skeuo-btn skeuo-btn-secondary h-11 px-4 py-2.5 text-xs sm:text-sm font-bold shrink-0 flex items-center space-x-1.5 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table Monthly Matrix (Tactile Ledger) -->
            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl shadow-sm">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center">No</th>
                            <th class="py-3 px-4">NISN & Nama Siswa</th>
                            <th class="py-3 px-4 text-center text-emerald-700 bg-emerald-50/50">Hadir (H)</th>
                            <th class="py-3 px-4 text-center text-amber-700 bg-amber-50/50">Terlambat (T)</th>
                            <th class="py-3 px-4 text-center text-blue-700 bg-blue-50/50">Izin (I)</th>
                            <th class="py-3 px-4 text-center text-orange-700 bg-orange-50/50">Sakit (S)</th>
                            <th class="py-3 px-4 text-center text-red-700 bg-red-50/50">Alpha (A)</th>
                            <th class="py-3 px-4 text-center font-bold">Total Hari</th>
                            <th class="py-3 px-4 text-center font-bold">% Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($monthlyData as $idx => $row)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="py-3 px-4 text-center font-mono text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $row['student']->name }}</div>
                                    <div class="text-[10px] font-mono text-slate-400">NISN: {{ $row['student']->nisn }}</div>
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-emerald-700 bg-emerald-50/20">{{ $row['hadir'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700 bg-amber-50/20">{{ $row['terlambat'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-blue-700 bg-blue-50/20">{{ $row['izin'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-orange-700 bg-orange-50/20">{{ $row['sakit'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-red-700 bg-red-50/20">{{ $row['alpa'] }}</td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">{{ $row['total'] }}</td>
                                <td class="py-3 px-4 text-center font-bold">
                                    <span class="skeuo-badge px-2.5 py-1 rounded-full text-[10px] font-bold {{ $row['percentage'] >= 85 ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-red-100 text-red-800 border-red-200' }}">
                                        {{ $row['percentage'] }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-slate-400 text-sm">
                                    Pilih kelas dan bulan di atas untuk melihat rekapitulasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 3: REKAP RAPORT SEMESTER -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'semester'" class="p-6 space-y-6">
            <div class="bg-indigo-50/80 border border-indigo-200/80 p-4 rounded-2xl text-indigo-900 flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-200 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-11.25 0H4.5A2.25 2.25 0 0 1 2.25 16.5V6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 0 1 1.123-.08m0 0A2.251 2.251 0 0 1 7.5 2.25H9c1.012 0 1.867.668 2.15 1.586M9 12h6m-6 3h6m-6 3h3" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Format Rekapitulasi Presensi untuk Raport Siswa</h4>
                        <p class="text-xs text-indigo-700">Tabel di bawah disesuaikan dengan format pengisian buku raport sekolah (Sakit, Izin, Tanpa Keterangan).</p>
                    </div>
                </div>
            </div>

            <!-- Filter Bar Semester (Tactile Inset Well) -->
            <form method="GET" action="{{ route('admin.reports.daily') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end skeuo-inset p-5 rounded-2xl">
                <input type="hidden" name="tab" value="semester">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran</label>
                    <select name="academic_year_id" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        @foreach($academicYears as $ay)
                            <option value="{{ $ay->id }}" {{ $selectedAcademicYearId == $ay->id ? 'selected' : '' }}>{{ $ay->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Semester</label>
                    <select name="semester_type" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        <option value="1" {{ $semesterType == '1' ? 'selected' : '' }}>Semester 1 (Ganjil - Juli s/d Des)</option>
                        <option value="2" {{ $semesterType == '2' ? 'selected' : '' }}>Semester 2 (Genap - Jan s/d Juni)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas</label>
                    <select name="semester_class_id" required class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ $semesterClassId == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="skeuo-btn skeuo-btn-primary w-full h-11 py-2.5 text-xs sm:text-sm font-bold shadow-md">
                        Filter Raport
                    </button>
                    @if($semesterClassId)
                        <a href="{{ route('admin.reports.print_semester', ['semester_type' => $semesterType, 'academic_year_id' => $selectedAcademicYearId, 'class_id' => $semesterClassId]) }}" target="_blank"
                            class="skeuo-btn skeuo-btn-secondary h-11 px-4 py-2.5 text-xs sm:text-sm font-bold shrink-0 flex items-center space-x-1.5 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table Semester Raport (Tactile Ledger) -->
            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl shadow-sm">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 w-10 text-center">No</th>
                            <th class="py-3.5 px-4">NISN & Nama Siswa</th>
                            <th class="py-3.5 px-4 text-center text-orange-800 bg-orange-50/70">Sakit (S)</th>
                            <th class="py-3.5 px-4 text-center text-blue-800 bg-blue-50/70">Izin (I)</th>
                            <th class="py-3.5 px-4 text-center text-red-800 bg-red-50/70">Tanpa Keterangan / Alpa (A)</th>
                            <th class="py-3.5 px-4">Format Teks Input Raport</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($semesterData as $idx => $row)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $row['student']->name }}</div>
                                    <div class="text-[10px] font-mono text-slate-400">NISN: {{ $row['student']->nisn }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-orange-800 bg-orange-50/30 text-sm">
                                    {{ $row['sakit'] }} <span class="text-[10px] font-normal text-slate-500">hari</span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-blue-800 bg-blue-50/30 text-sm">
                                    {{ $row['izin'] }} <span class="text-[10px] font-normal text-slate-500">hari</span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-red-800 bg-red-50/30 text-sm">
                                    {{ $row['alpa'] }} <span class="text-[10px] font-normal text-slate-500">hari</span>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-600 bg-slate-50/50">
                                    Sakit: {{ $row['sakit'] }} hr | Izin: {{ $row['izin'] }} hr | Alpa: {{ $row['alpa'] }} hr
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                    Pilih kelas dan semester untuk menampilkan data rekap raport.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
