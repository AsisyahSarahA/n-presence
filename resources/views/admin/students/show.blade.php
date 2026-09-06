@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $student->name)
@section('header_title', 'Detail & Riwayat Kehadiran Siswa')

@section('content')
<div class="space-y-6">

    <!-- Top Action Toolbar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center space-x-2 px-4 py-2 skeuo-btn skeuo-btn-light text-slate-700 rounded-xl text-xs font-bold transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Daftar Siswa</span>
        </a>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.qr-cards.print-single', $student->id) }}" target="_blank" class="px-4 py-2 skeuo-btn skeuo-btn-secondary text-white rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                </svg>
                <span>Cetak Kartu QR</span>
            </a>
            <a href="{{ route('admin.students.edit', $student->id) }}" class="px-4 py-2 skeuo-btn skeuo-btn-primary text-white rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Edit Profil</span>
            </a>
        </div>
    </div>

    <!-- Student Info Card Banner -->
    <div class="skeuo-card rounded-3xl p-6 flex flex-col md:flex-row items-center md:items-start gap-6">
        @if($student->photo_path)
            <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto {{ $student->name }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-md shrink-0">
        @else
            <div class="w-24 h-24 rounded-2xl bg-slate-100 text-primary flex items-center justify-center font-extrabold text-3xl border border-slate-200 shadow-[inset_0_2px_4px_rgba(0,0,0,0.06),0_1px_0_#ffffff] shrink-0">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
        @endif

        <div class="flex-1 text-center md:text-left space-y-2">
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                <span class="px-3 py-1 bg-slate-100 text-slate-800 rounded-xl text-xs font-bold border border-slate-200 shadow-[inset_0_1px_0_#ffffff]">
                    Kelas {{ $student->classRoom->name ?? '-' }}
                </span>
                <span class="px-3 py-1 rounded-xl text-xs font-bold border shadow-[inset_0_1px_0_#ffffff] {{ $student->gender == 'L' ? 'bg-blue-50 text-blue-800 border-blue-200' : 'bg-pink-50 text-pink-800 border-pink-200' }}">
                    {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-800 rounded-xl text-xs font-bold border border-emerald-200 shadow-[inset_0_1px_0_#ffffff]">
                    Aktif
                </span>
            </div>

            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $student->name }}</h2>
            <p class="text-xs font-mono text-slate-500">NISN: <strong class="text-slate-800">{{ $student->nisn }}</strong> | Tahun Ajaran: <strong>{{ $student->classRoom->academicYear->name ?? '-' }}</strong></p>
        </div>
    </div>

    <!-- Attendance Summary Badges (Skeuomorphic Theme) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div class="skeuo-stat-card p-4 rounded-2xl text-center">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Rekam</div>
            <div class="text-xl font-extrabold text-slate-800 mt-1">{{ $summary['total_records'] }}</div>
        </div>
        <div class="skeuo-stat-card p-4 rounded-2xl text-center">
            <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Hadir Tepat</div>
            <div class="text-xl font-extrabold text-emerald-700 mt-1">{{ $summary['hadir'] }}</div>
        </div>
        <div class="skeuo-stat-card p-4 rounded-2xl text-center">
            <div class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Terlambat</div>
            <div class="text-xl font-extrabold text-amber-700 mt-1">{{ $summary['terlambat'] }}</div>
        </div>
        <div class="skeuo-stat-card p-4 rounded-2xl text-center">
            <div class="text-[10px] font-bold text-sky-600 uppercase tracking-wider">Izin</div>
            <div class="text-xl font-extrabold text-sky-700 mt-1">{{ $summary['izin'] }}</div>
        </div>
        <div class="skeuo-stat-card p-4 rounded-2xl text-center">
            <div class="text-[10px] font-bold text-amber-800 uppercase tracking-wider">Sakit</div>
            <div class="text-xl font-extrabold text-amber-800 mt-1">{{ $summary['sakit'] }}</div>
        </div>
        <div class="skeuo-stat-card p-4 rounded-2xl text-center">
            <div class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">Alpha</div>
            <div class="text-xl font-extrabold text-rose-700 mt-1">{{ $summary['alpa'] }}</div>
        </div>
    </div>

    <!-- Attendance History Table Card -->
    <div class="skeuo-card rounded-3xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/80 flex items-center justify-between">
            <h3 class="font-extrabold text-slate-800 text-sm tracking-tight">Riwayat Kehadiran Siswa</h3>
            <span class="text-xs text-slate-500 font-medium">Menampilkan {{ $attendances->count() }} dari {{ $attendances->total() }} rekaman</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3.5 px-4 w-10 text-center">No</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4 text-center">Status Absensi</th>
                        <th class="py-3.5 px-4 text-center">Jam Masuk</th>
                        <th class="py-3.5 px-4 text-center">Jam Pulang</th>
                        <th class="py-3.5 px-4 text-center">Keterlambatan</th>
                        <th class="py-3.5 px-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($attendances as $idx => $att)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-3.5 px-4 text-slate-400 font-mono text-center">{{ $idx + 1 + ($attendances->currentPage() - 1) * $attendances->perPage() }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $effStatus = $att->effective_status;
                                    $badgeColor = match ($effStatus) {
                                        'Hadir' => 'bg-emerald-50 text-emerald-800 border-emerald-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(16,185,129,0.15)]',
                                        'Terlambat' => 'bg-amber-50 text-amber-800 border-amber-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)]',
                                        'Sakit' => 'bg-amber-50 text-amber-900 border-amber-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)]',
                                        'Izin' => 'bg-sky-50 text-sky-800 border-sky-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(14,165,233,0.15)]',
                                        'Alpa' => 'bg-rose-50 text-rose-800 border-rose-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(244,63,94,0.15)]',
                                        default => 'bg-slate-100 text-slate-500 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                    {{ $effStatus }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800">
                                {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('H:i') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($att->time_out)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-900 border border-sky-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(14,165,233,0.15)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1 text-sky-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($att->time_out)->format('H:i') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200 shadow-[inset_0_1px_0_#ffffff]">
                                        Menunggu Pulang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-semibold text-amber-700">
                                {{ $att->late_duration_minutes > 0 ? $att->late_duration_minutes . ' menit' : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $att->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 font-medium">
                                Belum ada riwayat presensi untuk siswa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
