@extends('layouts.app')

@section('title', 'Kehadiran Manual per Kelas')
@section('header_title', 'Kehadiran Manual per Kelas')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-primary to-slate-800 rounded-3xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-wide">Lembar Presensi Manual per Kelas</h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">
                Kelola dan perbarui data kehadiran seluruh siswa dalam satu kelas secara sekaligus. Gunakan fitur tombol aksi cepat untuk mengisi absensi secara efisien.
            </p>
        </div>
        <div class="flex items-center space-x-2 shrink-0">
            <span class="px-3.5 py-1.5 bg-white/10 border border-white/20 rounded-xl text-xs font-semibold text-slate-200">
                📅 {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-2xl text-sm font-semibold flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- FILTER CARD -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.attendances.manual.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label for="date" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pilih Tanggal</label>
                <input type="date" name="date" id="date" value="{{ $date }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all font-medium text-slate-800 bg-slate-50">
            </div>

            <div>
                <label for="class_id" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pilih Kelas</label>
                <select name="class_id" id="class_id" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all bg-slate-50 font-medium text-slate-800">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ (string)$classId === (string)$class->id ? 'selected' : '' }}>
                            Kelas {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <span>Tampilkan Presensi Kelas</span>
                </button>
            </div>
        </form>
    </div>

    @if ($classId)
        <!-- SUMMARY STATS BADGES -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
            <div class="bg-white border border-slate-200 p-3.5 rounded-2xl shadow-sm text-center">
                <div class="text-[10px] font-bold uppercase text-slate-400">Total Siswa</div>
                <div class="text-xl font-extrabold text-slate-800 mt-1">{{ $summary['total'] }}</div>
            </div>
            <div class="bg-emerald-50/80 border border-emerald-200/80 p-3.5 rounded-2xl shadow-sm text-center">
                <div class="text-[10px] font-bold uppercase text-emerald-600">Hadir</div>
                <div class="text-xl font-extrabold text-emerald-700 mt-1">{{ $summary['hadir'] }}</div>
            </div>
            <div class="bg-amber-50/80 border border-amber-200/80 p-3.5 rounded-2xl shadow-sm text-center">
                <div class="text-[10px] font-bold uppercase text-amber-600">Terlambat</div>
                <div class="text-xl font-extrabold text-amber-700 mt-1">{{ $summary['terlambat'] }}</div>
            </div>
            <div class="bg-blue-50/80 border border-blue-200/80 p-3.5 rounded-2xl shadow-sm text-center">
                <div class="text-[10px] font-bold uppercase text-blue-600">Izin</div>
                <div class="text-xl font-extrabold text-blue-700 mt-1">{{ $summary['izin'] }}</div>
            </div>
            <div class="bg-orange-50/80 border border-orange-200/80 p-3.5 rounded-2xl shadow-sm text-center">
                <div class="text-[10px] font-bold uppercase text-orange-600">Sakit</div>
                <div class="text-xl font-extrabold text-orange-700 mt-1">{{ $summary['sakit'] }}</div>
            </div>
            <div class="bg-red-50/80 border border-red-200/80 p-3.5 rounded-2xl shadow-sm text-center">
                <div class="text-[10px] font-bold uppercase text-red-600">Alpha</div>
                <div class="text-xl font-extrabold text-red-700 mt-1">{{ $summary['alpa'] }}</div>
            </div>
            <div class="bg-slate-100 border border-slate-200 p-3.5 rounded-2xl shadow-sm text-center col-span-2 sm:col-span-1">
                <div class="text-[10px] font-bold uppercase text-slate-500">Belum Absen</div>
                <div class="text-xl font-extrabold text-slate-600 mt-1">{{ $summary['belum_absen'] }}</div>
            </div>
        </div>

        <!-- TABLE SHEET CARD -->
        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
            
            <!-- Toolbar & Quick Action Buttons -->
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">
                        Lembar Presensi Siswa ({{ $students->count() }} siswa)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih status absensi untuk masing-masing siswa di bawah ini.</p>
                </div>

                <!-- Quick Action Buttons -->
                @if($students->isNotEmpty())
                    <div class="flex items-center space-x-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1 hidden lg:inline">Aksi Cepat:</span>
                        <button type="button" onclick="setAllStatus('Hadir')"
                            class="px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-xl text-xs font-bold transition-all border border-emerald-200 flex items-center space-x-1">
                            <span>✓ Tandai Semua Hadir</span>
                        </button>
                        <button type="button" onclick="setAllStatus('Alpa')"
                            class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-800 rounded-xl text-xs font-bold transition-all border border-red-200 flex items-center space-x-1">
                            <span>✕ Tandai Semua Alpa</span>
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
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                    <th class="py-3.5 px-4 w-10 text-center">No</th>
                                    <th class="py-3.5 px-4">NISN & Nama Siswa</th>
                                    <th class="py-3.5 px-4 text-center">Status Terakhir</th>
                                    <th class="py-3.5 px-4 text-center">Pilih Status Baru</th>
                                    <th class="py-3.5 px-4 w-56">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach ($students as $index => $student)
                                    <tr class="hover:bg-slate-50/80 transition-all">
                                        <td class="py-3.5 px-4 text-slate-400 font-mono text-center">{{ $index + 1 }}</td>
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-slate-900 text-sm">{{ $student->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">NISN: {{ $student->nisn }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            @php
                                                $badgeColor = match ($student->attendance_status) {
                                                    'Hadir' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                    'Terlambat' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                    'Sakit' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                    'Izin' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'Alpa' => 'bg-red-100 text-red-800 border-red-200',
                                                    default => 'bg-slate-100 text-slate-400 border-slate-200',
                                                };
                                                $badgeLabel = $student->attendance_status ?? 'Belum Absen';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                                {{ $badgeLabel }}
                                                @if($student->attendance_time_in)
                                                    <span class="ml-1 text-[10px] opacity-75">({{ \Carbon\Carbon::parse($student->attendance_time_in)->format('H:i') }})</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center justify-center flex-wrap gap-1.5">
                                                @foreach (['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa'] as $opt)
                                                    <label class="cursor-pointer">
                                                        <input type="radio" 
                                                            name="attendances[{{ $student->id }}][status]"
                                                            value="{{ $opt }}"
                                                            data-student-id="{{ $student->id }}"
                                                            {{ $student->attendance_status === $opt ? 'checked' : '' }}
                                                            class="sr-only peer status-radio-{{ $opt }}">
                                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold border-2 transition-all inline-block
                                                            border-slate-200 bg-white text-slate-500 hover:bg-slate-50
                                                            peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:shadow-sm">
                                                            {{ $opt }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                                <input type="hidden" name="attendances[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <input type="text" name="attendances[{{ $student->id }}][notes]"
                                                value="{{ $student->attendance_notes ?? '' }}"
                                                placeholder="Catatan opsional..."
                                                class="w-full px-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-slate-300">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-200 flex justify-between items-center bg-slate-50">
                        <span class="text-xs text-slate-400 font-medium">Klik Simpan untuk memperbarui seluruh status yang telah dipilih.</span>
                        <button type="button" onclick="confirmSave()"
                            class="px-6 py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Simpan Presensi Kelas</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 font-bold text-2xl">
                🏫
            </div>
            <h3 class="font-bold text-slate-800 text-base mb-1">Pilih Kelas Terlebih Dahulu</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto">Pilih tanggal dan kelas di atas, lalu klik <strong>Tampilkan Presensi Kelas</strong> untuk membuka lembar absensi.</p>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function setAllStatus(statusName) {
        const radios = document.querySelectorAll(`.status-radio-${statusName}`);
        radios.forEach(radio => {
            radio.checked = true;
        });

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `Seluruh siswa ditandai '${statusName}'`,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function confirmSave() {
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
</script>
@endsection
