@extends('layouts.app')

@section('title', 'Laporan Harian')
@section('header_title', 'Laporan Kehadiran')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Panel (Tactile Card) -->
    <div class="skeuo-card p-6">
        <form action="{{ route('admin.reports.daily') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" required
                    class="skeuo-input w-full h-11 px-4 text-sm text-slate-800 font-semibold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas</label>
                <select name="class_id" required class="skeuo-input w-full h-11 px-4 text-sm text-slate-800 font-semibold">
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->academicYear->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="skeuo-btn skeuo-btn-primary h-11 py-2.5 px-5 text-sm font-bold flex-1 shadow-md">
                    Cari Data
                </button>
            </div>
        </form>
    </div>

    @if($classId)
        <!-- Table Area (Tactile Ledger Card) -->
        <div class="skeuo-card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-[0_1px_0_#ffffff]">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Hasil Rekap Kehadiran</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Kelas: {{ $selectedClass->name }} | Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</p>
                </div>
                
                <!-- Export buttons (Tactile 3D Buttons) -->
                <div class="flex items-center space-x-2.5">
                    <form action="{{ route('admin.reports.export.pdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="class_id" value="{{ $classId }}">
                        <button type="submit" class="skeuo-btn skeuo-btn-danger px-4 py-2 text-xs font-bold flex items-center space-x-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span>Export PDF</span>
                        </button>
                    </form>

                    <form action="{{ route('admin.reports.export.excel') }}" method="GET">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="class_id" value="{{ $classId }}">
                        <button type="submit" class="skeuo-btn skeuo-btn-success px-4 py-2 text-xs font-bold flex items-center space-x-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5h7.5m-7.5 0v1.5m7.5-1.5c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-7.5 0h7.5m-7.5 0v1.5m0 0h7.5m-7.5 0v1.5" />
                            </svg>
                            <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-6 text-center w-12">No</th>
                            <th class="py-3.5 px-6">NISN</th>
                            <th class="py-3.5 px-6">Nama Lengkap</th>
                            <th class="py-3.5 px-6 text-center">Jam Masuk</th>
                            <th class="py-3.5 px-6 text-center">Jam Pulang</th>
                            <th class="py-3.5 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-slate-50/60 transition-all">
                                <td class="py-3.5 px-6 text-center font-medium">{{ $loop->iteration + ($classId ? ($attendances->currentPage() - 1) * $attendances->perPage() : 0) }}</td>
                                <td class="py-3.5 px-6 font-mono text-slate-500">{{ $attendance->student->nisn }}</td>
                                <td class="py-3.5 px-6 font-bold text-slate-900">{{ $attendance->student->name }}</td>
                                <td class="py-3.5 px-6 text-center font-mono">{{ $attendance->time_in ?? '-' }}</td>
                                <td class="py-3.5 px-6 text-center font-mono">{{ $attendance->time_out ?? '-' }}</td>
                                <td class="py-3.5 px-6 text-center">
                                    @php $effStatus = $attendance->effective_status; @endphp
                                    @if($effStatus == 'Hadir')
                                        <span class="skeuo-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border-emerald-200">
                                            Hadir
                                        </span>
                                    @elseif($effStatus == 'Terlambat')
                                        <span class="skeuo-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border-amber-200">
                                            Terlambat
                                        </span>
                                    @elseif($effStatus == 'Izin')
                                        <span class="skeuo-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border-blue-200">
                                            Izin
                                        </span>
                                    @elseif($effStatus == 'Sakit')
                                        <span class="skeuo-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 border-orange-200">
                                            Sakit
                                        </span>
                                    @else
                                        <span class="skeuo-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border-red-200">
                                            {{ $effStatus }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                                            Terlambat
                                        </span>
                                    @elseif($effStatus == 'Alpa')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                            Alpa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800">
                                            {{ $effStatus }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">Belum ada rekaman kehadiran untuk kriteria pencarian ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator && $attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-400 shadow-sm">
            Silakan pilih Tanggal dan Kelas terlebih dahulu untuk menampilkan data rekap absensi.
        </div>
    @endif
</div>
@endsection
