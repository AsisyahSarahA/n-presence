@extends('layouts.app')

@section('title', 'Kelola Kehadiran Manual')
@section('header_title', 'Manajemen Kehadiran per Kelas')

@section('content')
<div class="space-y-6">

    {{-- FILTER CARD --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.attendances.manual.index') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-48">
                <label for="date" class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ $date }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all">
            </div>
            <div class="w-full md:w-64">
                <label for="class_id" class="block text-xs font-semibold text-slate-600 mb-1.5">Kelas</label>
                <select name="class_id" id="class_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all bg-white">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ (string)$classId === (string)$class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="w-full md:w-auto px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <span>Tampilkan Data</span>
            </button>
        </form>
    </div>

    {{-- TABLE CARD --}}
    @if ($classId)
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm">
                    Daftar Siswa Perlu Diperbarui
                    <span class="text-slate-400 font-normal">({{ $students->count() }} siswa)</span>
                </h3>
                <span class="text-[10px] text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                    {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>

            @if ($students->isEmpty())
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-slate-300 mb-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-sm text-slate-400">Semua siswa di kelas ini sudah tercatat <strong>Hadir</strong> pada tanggal ini.</p>
                </div>
            @else
                <form method="POST" action="{{ route('admin.attendances.manual.store') }}" id="formBulk">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                                    <th class="py-3.5 px-4 w-10">No</th>
                                    <th class="py-3.5 px-4">NISN</th>
                                    <th class="py-3.5 px-4">Nama Siswa</th>
                                    <th class="py-3.5 px-4">Status Saat Ini</th>
                                    <th class="py-3.5 px-4">Status Baru</th>
                                    <th class="py-3.5 px-4 w-48">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach ($students as $index => $student)
                                    <tr class="hover:bg-slate-50/50 transition-all">
                                        <td class="py-3 px-4 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 font-mono text-slate-500">{{ $student->nisn }}</td>
                                        <td class="py-3 px-4 font-semibold text-slate-900">{{ $student->name }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $badgeColor = match ($student->attendance_status) {
                                                    'Hadir' => 'bg-emerald-100 text-emerald-700',
                                                    'Terlambat' => 'bg-amber-100 text-amber-700',
                                                    'Sakit' => 'bg-red-100 text-red-700',
                                                    'Izin' => 'bg-blue-100 text-blue-700',
                                                    'Alpa' => 'bg-slate-200 text-slate-600',
                                                    default => 'bg-slate-100 text-slate-400',
                                                };
                                                $badgeLabel = $student->attendance_status ?? 'Belum Absen';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $badgeColor }}">
                                                {{ $badgeLabel }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach (['Hadir', 'Sakit', 'Izin', 'Alpa'] as $opt)
                                                    <label class="flex items-center space-x-1.5 cursor-pointer group">
                                                        <input type="radio" name="attendances[{{ $student->id }}][status]"
                                                            value="{{ $opt }}"
                                                            {{ $student->attendance_status === $opt ? 'checked' : '' }}
                                                            class="peer sr-only">
                                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold border-2 transition-all
                                                            {{ $student->attendance_status === $opt
                                                                ? ($opt === 'Hadir' ? 'border-emerald-400 bg-emerald-50 text-emerald-700'
                                                                    : ($opt === 'Sakit' ? 'border-red-400 bg-red-50 text-red-700'
                                                                        : ($opt === 'Izin' ? 'border-blue-400 bg-blue-50 text-blue-700'
                                                                            : 'border-slate-400 bg-slate-50 text-slate-700')))
                                                                : 'border-transparent bg-slate-100 text-slate-400 group-hover:bg-slate-200' }}
                                                            peer-checked:{{ $opt === 'Hadir' ? 'border-emerald-400 bg-emerald-50 text-emerald-700'
                                                                : ($opt === 'Sakit' ? 'border-red-400 bg-red-50 text-red-700'
                                                                    : ($opt === 'Izin' ? 'border-blue-400 bg-blue-50 text-blue-700'
                                                                        : 'border-slate-400 bg-slate-50 text-slate-700')) }}">
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
                                                placeholder="Ket. (opsional)"
                                                class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all placeholder:text-slate-300">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
                        <button type="button" onclick="confirmSave()"
                            class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Simpan Perubahan Massal</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-slate-300 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <p class="text-sm text-slate-400">Pilih <strong>Kelas</strong> dan klik <strong>Tampilkan Data</strong> untuk memulai.</p>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function confirmSave() {
        Swal.fire({
            title: 'Simpan perubahan massal?',
            text: 'Data kehadiran yang dipilih akan disimpan dan ditimpa.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Simpan!',
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
                document.getElementById('formBulk').submit();
            }
        });
    }
</script>
@endsection
