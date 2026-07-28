@extends('layouts.app')

@section('title', 'Cetak Kartu QR')
@section('header_title', 'Cetak Kartu QR')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-150">
            <h3 class="font-bold text-slate-800 text-lg">Cetak Satu Kartu</h3>
            <p class="text-xs text-slate-500 mt-1">Cetak ulang kartu siswa yang hilang atau rusak.</p>
        </div>

        <div class="p-6">
            <form class="space-y-4" onsubmit="handlePrintSingle(event)">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Siswa</label>
                    <select id="student_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                        <option value="" disabled selected>-- Cari & Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} (NISN: {{ $student->nisn }}) - {{ $student->classRoom->name ?? 'Tanpa Kelas' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                        </svg>
                        <span>Cetak Kartu</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-150">
            <h3 class="font-bold text-slate-800 text-lg">Cetak Per Kelas</h3>
            <p class="text-xs text-slate-500 mt-1">Cetak kartu seluruh siswa dalam satu kelas tertentu.</p>
        </div>

        <div class="p-6">
            <form id="form-print" class="space-y-4" onsubmit="handlePrint(event)">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Kelas</label>
                    <select id="class_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                        <option value="" disabled selected>Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->academicYear->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center space-x-2">
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