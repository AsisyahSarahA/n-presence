@extends('layouts.app')

@section('title', 'Laporan Harian')
@section('header_title', 'Laporan Kehadiran')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Panel -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form action="{{ route('admin.reports.daily') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" required
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-semibold">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kelas</label>
                <select name="class_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-semibold">
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->academicYear->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-primary hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm flex-1">
                    Cari Data
                </button>
            </div>
        </form>
    </div>

    @if($classId)
        <!-- Table Area -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-150 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Hasil Rekap Kehadiran</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Kelas: {{ $selectedClass->name }} | Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</p>
                </div>
                
                <!-- Export buttons -->
                <div class="flex items-center space-x-2">
                    <form action="{{ route('admin.reports.export.pdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="class_id" value="{{ $classId }}">
                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-4 py-2 rounded-xl text-xs font-bold border border-rose-200 transition-all flex items-center space-x-1.5 shadow-sm">
                            <span>⬇️ Export PDF</span>
                        </button>
                    </form>

                    <form action="{{ route('admin.reports.export.excel') }}" method="GET">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="class_id" value="{{ $classId }}">
                        <button type="submit" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl text-xs font-bold border border-emerald-200 transition-all flex items-center space-x-1.5 shadow-sm">
                            <span>⬇️ Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
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
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="py-3.5 px-6 text-center font-medium">{{ $loop->iteration + ($classId ? ($attendances->currentPage() - 1) * $attendances->perPage() : 0) }}</td>
                                <td class="py-3.5 px-6 font-mono text-slate-500">{{ $attendance->student->nisn }}</td>
                                <td class="py-3.5 px-6 font-bold text-slate-900">{{ $attendance->student->name }}</td>
                                <td class="py-3.5 px-6 text-center font-mono">{{ $attendance->time_in ?? '-' }}</td>
                                <td class="py-3.5 px-6 text-center font-mono">{{ $attendance->time_out ?? '-' }}</td>
                                <td class="py-3.5 px-6 text-center">
                                    @if($attendance->status == 'Hadir')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Hadir
                                        </span>
                                    @elseif($attendance->status == 'Terlambat')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                            Terlambat
                                        </span>
                                    @elseif($attendance->status == 'Alpa')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                            Alpa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800">
                                            {{ $attendance->status }}
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
