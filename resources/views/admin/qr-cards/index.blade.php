@extends('layouts.app')

@section('title', 'Cetak Kartu QR')
@section('header_title', 'Cetak Kartu QR')

@section('content')
<div class="space-y-6">

    <!-- Page Hero -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-primary via-[#27497c] to-secondary px-6 py-7 text-white shadow-xl">
        <div class="absolute -top-16 -right-10 h-52 w-52 rounded-full bg-blue-400/20 blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-indigo-300/10 blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/20 text-[11px] font-semibold text-blue-200 mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Manajemen Kartu QR
                </span>
                <h1 class="text-2xl font-black tracking-tight">Cetak Kartu QR Siswa</h1>
                <p class="text-xs text-blue-200/90 mt-1.5 max-w-lg leading-relaxed">
                    Cetak kartu absensi digital untuk siswa, baik satu per satu maupun massal berdasarkan kelas.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2 z-10">
                <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl px-4 py-2.5 flex items-center space-x-2.5">
                    <span class="w-8 h-8 rounded-xl bg-emerald-400/20 text-emerald-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[9px] font-semibold text-blue-200 uppercase tracking-wider">Total Siswa</p>
                        <p class="text-lg font-black text-white leading-tight">{{ count($students) }}</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl px-4 py-2.5 flex items-center space-x-2.5">
                    <span class="w-8 h-8 rounded-xl bg-indigo-400/20 text-indigo-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[9px] font-semibold text-blue-200 uppercase tracking-wider">Total Kelas</p>
                        <p class="text-lg font-black text-white leading-tight">{{ count($classes) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Grid - Side by Side -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Cetak Satu Kartu -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
            <div class="relative px-6 py-5 bg-gradient-to-r from-blue-50 via-blue-50/60 to-transparent border-b border-blue-100/70">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white flex items-center justify-center shadow-md shadow-blue-500/20 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight">Cetak Satu Kartu</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Cetak ulang kartu siswa yang hilang atau rusak.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 text-[9px] font-bold uppercase tracking-wider">Perorangan</span>
                </div>
            </div>

            <div class="p-6 flex-1 flex flex-col">
                <form class="space-y-5 flex-1 flex flex-col" onsubmit="handlePrintSingle(event)">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-2">Pilih Siswa</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4.5 h-4.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <select id="student_id" required class="w-full pl-10 pr-10 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 focus:bg-white transition-all text-slate-800 appearance-none">
                                <option value="" disabled selected>-- Cari & Pilih Siswa --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} (NISN: {{ $student->nisn }}) - {{ $student->classRoom->name ?? 'Tanpa Kelas' }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1"></div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-2xl text-sm font-bold transition-all shadow-lg shadow-blue-500/20 flex items-center space-x-2 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak Kartu</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cetak Per Kelas -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
            <div class="relative px-6 py-5 bg-gradient-to-r from-indigo-50 via-indigo-50/60 to-transparent border-b border-indigo-100/70">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-primary text-white flex items-center justify-center shadow-md shadow-indigo-500/20 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight">Cetak Per Kelas</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Cetak kartu seluruh siswa dalam satu kelas tertentu.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200 text-[9px] font-bold uppercase tracking-wider">Massal</span>
                </div>
            </div>

            <div class="p-6 flex-1 flex flex-col">
                <form id="form-print" class="space-y-5 flex-1 flex flex-col" onsubmit="handlePrint(event)">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-2">Pilih Kelas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4.5 h-4.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A5.998 5.998 0 0 1 1.228 6.75 12.06 12.06 0 0 1 12 3c3.78 0 7.21 1.74 9.518 4.5a5.998 5.998 0 0 1-2.658 2.584m-15.482 0A50.584 50.584 0 0 1 12 13.713a50.58 50.58 0 0 1 8.232-3.566m0 0v-1.14" />
                                </svg>
                            </div>
                            <select id="class_id" required class="w-full pl-10 pr-10 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all text-slate-800 appearance-none">
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->academicYear->name }})</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1"></div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-primary to-secondary hover:from-[#16293f] hover:to-[#2f6fd4] text-white px-6 py-3 rounded-2xl text-sm font-bold transition-all shadow-lg shadow-primary/20 flex items-center space-x-2 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                            </svg>
                            <span>Cetak Massal</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Info Note -->
    <div class="flex items-start space-x-3 bg-white/60 backdrop-blur-sm border border-slate-200/70 rounded-2xl px-5 py-4">
        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed">
            Kartu QR akan dibuka dalam <span class="font-bold text-slate-700">tab baru</span> berisi pratinjau siap cetak.
            Pastikan printer telah terpasang dan kertas kartu sudah tersedia sebelum mencetak.
        </p>
    </div>

</div>

<script>
    function handlePrint(e) {
        e.preventDefault();
        const classId = document.getElementById('class_id').value;
        if(classId) {
            window.open(`/admin/qr-cards/print/${classId}`, '_blank');
        }
    }

    function handlePrintSingle(e) {
        e.preventDefault();
        const studentId = document.getElementById('student_id').value;
        if(studentId) {
            window.open(`/admin/qr-cards/print-single/${studentId}`, '_blank');
        }
    }
</script>
@endsection
