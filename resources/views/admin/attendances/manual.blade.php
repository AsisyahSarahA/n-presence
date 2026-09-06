@extends('layouts.app')

@section('title', 'Kehadiran Manual per Kelas')
@section('header_title', 'Kehadiran Manual per Kelas')

@section('content')
<div class="space-y-6">

    <!-- Header Banner Slab -->
    <div class="bg-gradient-to-br from-[#182e4b] via-primary to-[#0f1d30] rounded-3xl p-6 text-white border-t border-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.25),0_10px_24px_-4px_rgba(15,23,42,0.35)] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-[11px] font-semibold text-blue-200 mb-2 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Lembar Presensi Kelas</span>
            </div>
            <h2 class="text-xl font-black tracking-tight text-white drop-shadow-sm">Presensi Manual per Kelas</h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl leading-relaxed">
                Kelola dan perbarui data kehadiran seluruh siswa dalam satu kelas secara serentak. Tombol status didesain tactile interaktif untuk percepatan input presensi harian.
            </p>
        </div>
        <div class="flex items-center space-x-2 shrink-0">
            <span class="inline-flex items-center space-x-2 px-4 py-2 bg-[#0f1d30]/70 border border-white/15 rounded-2xl text-xs font-bold text-slate-200 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M12 3v2.25m5.25-2.25V5.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Z" />
                </svg>
                <span>{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</span>
            </span>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-gradient-to-r from-emerald-50 to-white border-l-4 border-emerald-500 text-emerald-900 rounded-2xl text-sm font-semibold flex items-center justify-between shadow-[0_2px_8px_rgba(16,185,129,0.12)]">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- FILTER CARD -->
    <div class="skeuo-card p-6">
        <form method="GET" action="{{ route('admin.attendances.manual.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <!-- Custom Tanggal -->
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ $date }}" required
                        class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                </div>

                <!-- Pilih Kelas -->
                <div>
                    <label for="class_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Kelas</label>
                    <select name="class_id" id="class_id" required
                        class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ (string)$classId === (string)$class->id ? 'selected' : '' }}>
                                Kelas {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cari Nama / NISN -->
                <div>
                    <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cari Nama / NISN</label>
                    <div class="relative">
                        <input type="text" name="search" id="search_input" value="{{ $search ?? '' }}"
                            placeholder="Ketik Nama atau NISN..." onkeyup="liveFilterTable()"
                            class="skeuo-input w-full h-11 pl-10 pr-4 text-sm font-semibold text-slate-800 placeholder:font-normal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>

                <!-- Filter Status -->
                <div>
                    <label for="status_filter" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Filter Status</label>
                    <select name="status_filter" id="status_filter_select" onchange="liveFilterTable()"
                        class="skeuo-input w-full h-11 px-4 text-sm font-semibold text-slate-800">
                        <option value="">-- Semua Status --</option>
                        <option value="Hadir" {{ ($statusFilter ?? '') === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Terlambat" {{ ($statusFilter ?? '') === 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="Izin" {{ ($statusFilter ?? '') === 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ ($statusFilter ?? '') === 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Alpa" {{ ($statusFilter ?? '') === 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        <option value="Belum Absen" {{ ($statusFilter ?? '') === 'Belum Absen' ? 'selected' : '' }}>Belum Absen</option>
                        <option value="Sudah Pulang" {{ ($statusFilter ?? '') === 'Sudah Pulang' ? 'selected' : '' }}>Sudah Pulang</option>
                        <option value="Belum Pulang" {{ ($statusFilter ?? '') === 'Belum Pulang' ? 'selected' : '' }}>Belum Pulang</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200/80">
                @if($search || $statusFilter)
                    <a href="{{ route('admin.attendances.manual.index', ['date' => $date, 'class_id' => $classId]) }}" 
                       class="skeuo-btn skeuo-btn-light h-11 px-4 text-xs sm:text-sm font-bold">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="skeuo-btn skeuo-btn-primary h-11 px-6 text-xs sm:text-sm font-bold shadow-md flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <span>Tampilkan Presensi Kelas</span>
                </button>
            </div>
        </form>
    </div>

    @if ($classId)
        <!-- SUMMARY STATS BADGES (Tactile Mini Cards) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            <div class="skeuo-stat-card p-3.5 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Siswa</div>
                <div class="text-xl font-black text-slate-800 mt-1">{{ $summary['total'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-emerald-200/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Hadir</div>
                <div class="text-xl font-black text-emerald-700 mt-1">{{ $summary['hadir'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-amber-200/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Terlambat</div>
                <div class="text-xl font-black text-amber-700 mt-1">{{ $summary['terlambat'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-purple-200/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-purple-600">Sdh Pulang</div>
                <div class="text-xl font-black text-purple-700 mt-1">{{ $summary['sudah_pulang'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-blue-200/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Izin</div>
                <div class="text-xl font-black text-blue-700 mt-1">{{ $summary['izin'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-orange-200/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-orange-600">Sakit</div>
                <div class="text-xl font-black text-orange-700 mt-1">{{ $summary['sakit'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-rose-200/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Alpha</div>
                <div class="text-xl font-black text-rose-700 mt-1">{{ $summary['alpa'] }}</div>
            </div>
            <div class="skeuo-stat-card p-3.5 text-center !border-slate-300/80">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Belum Absen</div>
                <div class="text-xl font-black text-slate-600 mt-1">{{ $summary['belum_absen'] }}</div>
            </div>
        </div>

        <!-- TABLE SHEET CARD -->
        <div class="skeuo-card overflow-hidden">
            
            <!-- Toolbar & Quick Action Buttons -->
            <div class="px-6 py-4 border-b border-slate-200/80 bg-gradient-to-r from-slate-50 to-white flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-black text-slate-800 text-sm flex items-center space-x-2">
                        <span>Lembar Presensi Siswa</span>
                        <span class="skeuo-badge px-2.5 py-0.5 bg-primary/10 text-primary border-primary/20 text-xs font-black" id="visible-count-badge">
                            {{ $students->count() }} siswa
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Klik tombol switch status pada masing-masing baris siswa.</p>
                </div>

                <!-- Quick Action Buttons -->
                @if($students->isNotEmpty())
                    <div class="flex items-center space-x-2.5">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1 hidden lg:inline">Aksi Cepat:</span>
                        <button type="button" onclick="setAllStatus('Hadir')"
                            class="skeuo-btn skeuo-btn-success text-xs py-1.5 px-3.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Tandai Semua Hadir</span>
                        </button>
                        <button type="button" onclick="setAllStatus('Alpa')"
                            class="skeuo-btn skeuo-btn-danger text-xs py-1.5 px-3.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            <span>Tandai Semua Alpa</span>
                        </button>
                    </div>
                @endif
            </div>

            @if ($students->isEmpty())
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-slate-300 mb-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <p class="text-sm text-slate-400 font-medium">Tidak ada siswa aktif ditemukan di kelas ini.</p>
                </div>
            @else
                <form method="POST" action="{{ route('admin.attendances.manual.store') }}" id="formBulk">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-100/70 border-b border-slate-200 text-slate-600 font-black uppercase tracking-wider text-[11px]">
                                    <th class="py-3.5 px-4 w-12 text-center">No</th>
                                    <th class="py-3.5 px-4">NISN & Nama Siswa</th>
                                    <th class="py-3.5 px-4 text-center">Status Masuk</th>
                                    <th class="py-3.5 px-4 text-center">Status Pulang</th>
                                    <th class="py-3.5 px-4 text-center">Pilih Status Baru</th>
                                    <th class="py-3.5 px-4 w-56">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach ($students as $index => $student)
                                    <tr class="hover:bg-blue-50/30 transition-all student-row" 
                                        data-timeout="{{ $student->attendance_time_out ? 'true' : 'false' }}"
                                        data-name="{{ strtolower($student->name) }}"
                                        data-nisn="{{ strtolower($student->nisn) }}"
                                        data-status="{{ $student->attendance_status ?? 'Belum Absen' }}"
                                        data-student-id="{{ $student->id }}">
                                        <td class="py-3 px-4 text-slate-400 font-mono font-bold text-center">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">
                                            <div class="font-black text-slate-800 text-sm tracking-tight">{{ $student->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono font-semibold">NISN: {{ $student->nisn }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @php
                                                $badgeStyle = match ($student->attendance_status) {
                                                    'Hadir' => 'bg-emerald-50 text-emerald-800 border-emerald-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(16,185,129,0.15)]',
                                                    'Terlambat' => 'bg-amber-50 text-amber-800 border-amber-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)]',
                                                    'Sakit' => 'bg-orange-50 text-orange-800 border-orange-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(249,115,22,0.15)]',
                                                    'Izin' => 'bg-blue-50 text-blue-800 border-blue-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(59,130,246,0.15)]',
                                                    'Alpa' => 'bg-rose-50 text-rose-800 border-rose-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(244,63,94,0.15)]',
                                                    default => 'bg-slate-100 text-slate-500 border-slate-300 shadow-[inset_0_1px_0_#ffffff]',
                                                };
                                                $badgeLabel = $student->attendance_status ?? 'Belum Absen';
                                            @endphp
                                            <span class="skeuo-badge px-3 py-1 font-bold {{ $badgeStyle }}">
                                                {{ $badgeLabel }}
                                                @if($student->attendance_time_in)
                                                    <span class="ml-1 text-[10px] opacity-75 font-mono">({{ \Carbon\Carbon::parse($student->attendance_time_in)->format('H:i') }})</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @if($student->attendance_time_out)
                                                <span class="skeuo-badge px-3 py-1 font-bold bg-purple-50 text-purple-800 border-purple-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(168,85,247,0.15)]">
                                                    Sudah Pulang
                                                    <span class="ml-1 text-[10px] opacity-75 font-mono">({{ \Carbon\Carbon::parse($student->attendance_time_out)->format('H:i') }})</span>
                                                </span>
                                            @else
                                                <span class="skeuo-badge px-3 py-1 font-bold bg-slate-100 text-slate-500 border-slate-300 shadow-[inset_0_1px_0_#ffffff]">
                                                    Belum Pulang
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center justify-center flex-wrap gap-1.5">
                                                @foreach (['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa'] as $opt)
                                                    <label class="cursor-pointer select-none">
                                                        <input type="radio" 
                                                            name="attendances[{{ $student->id }}][status]"
                                                            value="{{ $opt }}"
                                                            data-student-id="{{ $student->id }}"
                                                            {{ $student->attendance_status === $opt ? 'checked' : '' }}
                                                            class="sr-only peer status-radio-{{ $opt }}">
                                                        <span class="px-2.5 py-1 rounded-xl text-xs font-bold border transition-all inline-block
                                                            border-slate-200 bg-gradient-to-b from-white to-slate-50 text-slate-600 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.05),0_2px_0_#cbd5e1] hover:bg-slate-100
                                                            peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-[inset_0_2px_4px_rgba(0,0,0,0.35)] peer-checked:translate-y-[1px]">
                                                            {{ $opt }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                                <input type="hidden" name="attendances[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text" name="attendances[{{ $student->id }}][notes]"
                                                value="{{ $student->attendance_notes ?? '' }}"
                                                placeholder="Catatan opsional..."
                                                class="skeuo-input text-xs py-1.5 px-3 placeholder:text-slate-400">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-200/80 flex flex-col sm:flex-row justify-between items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                        <span class="text-xs text-slate-500 font-medium">Klik Simpan untuk memperbarui status presensi siswa secara permanen.</span>
                        <button type="button" onclick="confirmSave()" class="skeuo-btn skeuo-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Simpan Presensi Kelas</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @else
        <div class="skeuo-card p-12 text-center">
            <div class="w-16 h-16 bg-primary/10 text-primary border border-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-4 font-bold text-2xl shadow-[inset_0_1px_0_rgba(255,255,255,0.8),0_4px_10px_rgba(30,58,95,0.12)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <h3 class="font-black text-slate-800 text-base mb-1 tracking-tight">Pilih Kelas Terlebih Dahulu</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto leading-relaxed">Pilih tanggal dan kelas di atas, lalu klik <strong>Tampilkan Presensi Kelas</strong> untuk membuka lembar absensi.</p>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function liveFilterTable() {
        const searchInput = document.getElementById('search_input');
        const statusSelect = document.getElementById('status_filter_select');
        const badge = document.getElementById('visible-count-badge');
        
        if (!searchInput || !statusSelect) return;

        const searchVal = searchInput.value.toLowerCase().trim();
        const statusVal = statusSelect.value;
        const rows = document.querySelectorAll('.student-row');

        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const nisn = row.getAttribute('data-nisn') || '';
            const status = row.getAttribute('data-status') || 'Belum Absen';
            const isTimeout = row.getAttribute('data-timeout') === 'true';

            const matchesSearch = !searchVal || name.includes(searchVal) || nisn.includes(searchVal);
            
            let matchesStatus = true;
            if (statusVal === 'Sudah Pulang') {
                matchesStatus = isTimeout;
            } else if (statusVal === 'Belum Pulang') {
                matchesStatus = (status === 'Hadir' || status === 'Terlambat') && !isTimeout;
            } else if (statusVal) {
                matchesStatus = status === statusVal;
            }

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (badge) {
            badge.innerText = `${visibleCount} siswa`;
        }
    }

    function setAllStatus(statusName) {
        const radios = document.querySelectorAll(`.status-radio-${statusName}`);
        radios.forEach(radio => {
            // Hanya radio button pada baris yang terlihat (visible) yang di-check
            const row = radio.closest('tr');
            if (row && row.style.display !== 'none') {
                radio.checked = true;
            }
        });

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `Siswa yang tampil ditandai '${statusName}'`,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function confirmSave() {
        let unpulangSelected = [];
        const rows = document.querySelectorAll('tr[data-timeout]');

        rows.forEach(row => {
            const isTimeout = row.getAttribute('data-timeout') === 'true';
            const studentName = row.getAttribute('data-name');
            const selectedRadio = row.querySelector('input[type="radio"]:checked');

            if (selectedRadio && (selectedRadio.value === 'Hadir' || selectedRadio.value === 'Terlambat') && !isTimeout) {
                unpulangSelected.push(studentName);
            }
        });

        if (unpulangSelected.length > 0) {
            let sampleNames = unpulangSelected.slice(0, 3).map(n => n.toUpperCase()).join(', ');
            if (unpulangSelected.length > 3) sampleNames += `, dan ${unpulangSelected.length - 3} lainnya`;

            Swal.fire({
                title: 'Peringatan Scan Pulang!',
                html: `Terdapat <strong>${unpulangSelected.length} siswa</strong> (${sampleNames}) yang <strong>belum melakukan scan pulang</strong>.<br><br>Apakah Anda yakin ingin menetapkan status <strong>HADIR / TERLAMBAT</strong> secara paksa (Admin Override)?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Simpan Paksa!',
                cancelButtonText: 'Batal / Periksa Kembali',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl text-sm px-5 py-2 font-semibold',
                    cancelButton: 'rounded-xl text-sm px-5 py-2 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formBulk').submit();
                }
            });
        } else {
            Swal.fire({
                title: 'Simpan Presensi Kelas?',
                text: 'Seluruh pilihan status kehadiran siswa pada tanggal ini akan diperbarui.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e3a5f',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl text-sm px-5 py-2 font-semibold',
                    cancelButton: 'rounded-xl text-sm px-5 py-2 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formBulk').submit();
                }
            });
        }
    }
</script>
@endsection
