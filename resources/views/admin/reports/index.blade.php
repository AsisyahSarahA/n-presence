@extends('layouts.app')

@section('title', 'Laporan Absensi')
@section('header_title', 'Laporan & Rekapitulasi Presensi')

@section('content')
<div class="space-y-6" x-data="{ activeTab: '{{ $tab }}' }">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-primary to-slate-800 rounded-3xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-wide">Pusat Laporan Absensi Siswa</h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">
                Cetak dan ekspor Laporan Harian, Rekapitulasi Bulanan, serta Rekapitulasi Raport Semester resmi siap guna untuk keperluan administrasi sekolah.
            </p>
        </div>
        <div class="flex items-center space-x-2 shrink-0">
            <span class="px-3.5 py-1.5 bg-white/10 border border-white/20 rounded-xl text-xs font-semibold text-slate-200">
                🏫 {{ $schoolName }}
            </span>
        </div>
    </div>

    <!-- Tabbed Navigation Bar -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="flex border-b border-slate-200 bg-slate-50/80 px-6 pt-3 space-x-3 overflow-x-auto">
            <button @click="activeTab = 'daily'" 
                :class="activeTab === 'daily' ? 'border-primary text-primary bg-white shadow-sm font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="px-6 py-3 border-b-2 rounded-t-2xl text-sm transition-all flex items-center space-x-2 shrink-0">
                <span>📅 1. Laporan Harian</span>
            </button>

            <button @click="activeTab = 'monthly'" 
                :class="activeTab === 'monthly' ? 'border-primary text-primary bg-white shadow-sm font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="px-6 py-3 border-b-2 rounded-t-2xl text-sm transition-all flex items-center space-x-2 shrink-0">
                <span>📊 2. Rekapitulasi Bulanan</span>
            </button>

            <button @click="activeTab = 'semester'" 
                :class="activeTab === 'semester' ? 'border-primary text-primary bg-white shadow-sm font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="px-6 py-3 border-b-2 rounded-t-2xl text-sm transition-all flex items-center space-x-2 shrink-0">
                <span>📝 3. Rekap Raport Semester</span>
            </button>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 1: LAPORAN HARIAN -->
        <!-- ========================================================================= -->
        <div x-show="activeTab === 'daily'" class="p-6 space-y-6">
            <!-- Filter Bar Daily -->
            <form method="GET" action="{{ route('admin.reports.daily') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                <input type="hidden" name="tab" value="daily">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="daily_date" value="{{ $dailyDate }}" required
                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kelas</label>
                    <select name="daily_class_id" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ $dailyClassId == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                        Filter Daily
                    </button>
                    @if($dailyClassId)
                        <a href="{{ route('admin.reports.print_daily', ['date' => $dailyDate, 'class_id' => $dailyClassId]) }}" target="_blank"
                            class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shrink-0 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak Laporan</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Summary Cards Daily -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                <div class="bg-white border border-slate-200 p-3 rounded-2xl text-center shadow-sm">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Total Siswa</div>
                    <div class="text-lg font-bold text-slate-800 mt-0.5">{{ $dailySummary['total'] }}</div>
                </div>
                <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-2xl text-center shadow-sm">
                    <div class="text-[10px] font-bold text-emerald-600 uppercase">Hadir</div>
                    <div class="text-lg font-bold text-emerald-700 mt-0.5">{{ $dailySummary['hadir'] }}</div>
                </div>
                <div class="bg-amber-50 border border-amber-200 p-3 rounded-2xl text-center shadow-sm">
                    <div class="text-[10px] font-bold text-amber-600 uppercase">Terlambat</div>
                    <div class="text-lg font-bold text-amber-700 mt-0.5">{{ $dailySummary['terlambat'] }}</div>
                </div>
                <div class="bg-blue-50 border border-blue-200 p-3 rounded-2xl text-center shadow-sm">
                    <div class="text-[10px] font-bold text-blue-600 uppercase">Izin</div>
                    <div class="text-lg font-bold text-blue-700 mt-0.5">{{ $dailySummary['izin'] }}</div>
                </div>
                <div class="bg-orange-50 border border-orange-200 p-3 rounded-2xl text-center shadow-sm">
                    <div class="text-[10px] font-bold text-orange-600 uppercase">Sakit</div>
                    <div class="text-lg font-bold text-orange-700 mt-0.5">{{ $dailySummary['sakit'] }}</div>
                </div>
                <div class="bg-red-50 border border-red-200 p-3 rounded-2xl text-center shadow-sm">
                    <div class="text-[10px] font-bold text-red-600 uppercase">Alpha</div>
                    <div class="text-lg font-bold text-red-700 mt-0.5">{{ $dailySummary['alpa'] }}</div>
                </div>
            </div>

            <!-- Table Daily -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center">No</th>
                            <th class="py-3 px-4">NISN & Nama Siswa</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Jam Masuk</th>
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
                                        $bCol = match($att->status) {
                                            'Hadir' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'Terlambat' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'Izin' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'Sakit' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            default => 'bg-red-100 text-red-800 border-red-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $bCol }}">
                                        {{ $att->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-mono font-semibold">
                                    {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('H:i:s') : '-' }}
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
                                <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
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
            <!-- Filter Bar Monthly -->
            <form method="GET" action="{{ route('admin.reports.daily') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                <input type="hidden" name="tab" value="monthly">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Bulan</label>
                    <select name="monthly_month" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $monthlyMonth == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tahun</label>
                    <select name="monthly_year" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        @foreach(range(now()->year - 2, now()->year + 1) as $y)
                            <option value="{{ $y }}" {{ $monthlyYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kelas</label>
                    <select name="monthly_class_id" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ $monthlyClassId == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                        Filter Bulanan
                    </button>
                    @if($monthlyClassId)
                        <a href="{{ route('admin.reports.print_monthly', ['month' => $monthlyMonth, 'year' => $monthlyYear, 'class_id' => $monthlyClassId]) }}" target="_blank"
                            class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shrink-0 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak Bulanan</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table Monthly Matrix -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
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
                            <tr class="hover:bg-slate-50 transition-all">
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
                                    <span class="px-2.5 py-1 rounded-full text-[10px] {{ $row['percentage'] >= 85 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
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
            <div class="bg-indigo-50 border border-indigo-200/80 p-4 rounded-2xl text-indigo-900 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">📝</span>
                    <div>
                        <h4 class="font-bold text-sm">Format Rekapitulasi Presensi untuk Raport Siswa</h4>
                        <p class="text-xs text-indigo-700">Tabel di bawah disesuaikan dengan format pengisian buku raport sekolah (Sakit, Izin, Tanpa Keterangan).</p>
                    </div>
                </div>
            </div>

            <!-- Filter Bar Semester -->
            <form method="GET" action="{{ route('admin.reports.daily') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                <input type="hidden" name="tab" value="semester">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tahun Ajaran</label>
                    <select name="academic_year_id" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        @foreach($academicYears as $ay)
                            <option value="{{ $ay->id }}" {{ $selectedAcademicYearId == $ay->id ? 'selected' : '' }}>{{ $ay->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Semester</label>
                    <select name="semester_type" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        <option value="1" {{ $semesterType == '1' ? 'selected' : '' }}>Semester 1 (Ganjil - Juli s/d Des)</option>
                        <option value="2" {{ $semesterType == '2' ? 'selected' : '' }}>Semester 2 (Genap - Jan s/d Juni)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kelas</label>
                    <select name="semester_class_id" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary font-medium text-slate-800">
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ $semesterClassId == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                        Filter Raport
                    </button>
                    @if($semesterClassId)
                        <a href="{{ route('admin.reports.print_semester', ['semester_type' => $semesterType, 'academic_year_id' => $selectedAcademicYearId, 'class_id' => $semesterClassId]) }}" target="_blank"
                            class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shrink-0 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak Format Raport</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table Semester Raport -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 w-10 text-center">No</th>
                            <th class="py-3.5 px-4">NISN & Nama Siswa</th>
                            <th class="py-3.5 px-4 text-center text-orange-800 bg-orange-50">Sakit (S)</th>
                            <th class="py-3.5 px-4 text-center text-blue-800 bg-blue-50">Izin (I)</th>
                            <th class="py-3.5 px-4 text-center text-red-800 bg-red-50">Tanpa Keterangan / Alpa (A)</th>
                            <th class="py-3.5 px-4">Format Teks Input Raport</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($semesterData as $idx => $row)
                            <tr class="hover:bg-slate-50 transition-all">
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
