@extends('layouts.app')

@section('title', 'Izin & Sakit')
@section('header_title', 'Manajemen Izin & Sakit')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-150 bg-gradient-to-r from-slate-50 to-white">
            <h3 class="font-bold text-slate-800 text-lg">Catat Izin / Sakit Siswa</h3>
            <p class="text-xs text-slate-500 mt-0.5">Gunakan form ini untuk mencatat siswa yang tidak hadir karena izin atau sakit.</p>
        </div>

        <form id="permit-form" action="{{ route('admin.permits.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 {{ $errors->has('date') ? 'border-red-400 bg-red-50' : '' }}">
                @error('date')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Siswa</label>
                <select name="student_id" required
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 {{ $errors->has('student_id') ? 'border-red-400 bg-red-50' : '' }}">
                    <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>Pilih Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->nisn }} — {{ $student->name }} ({{ $student->classRoom->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Status</label>
                <div class="flex items-center space-x-4">
                    <label class="relative flex items-center cursor-pointer group">
                        <input type="radio" name="status" value="Izin" {{ old('status') == 'Izin' ? 'checked' : '' }} required class="sr-only peer">
                        <div class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all border-2 peer-checked:border-slate-400 peer-checked:bg-slate-100 peer-checked:text-slate-800 border-slate-200 bg-white text-slate-500 hover:bg-slate-50 peer-checked:shadow-sm">
                            ✉️ Izin
                        </div>
                    </label>
                    <label class="relative flex items-center cursor-pointer group">
                        <input type="radio" name="status" value="Sakit" {{ old('status') == 'Sakit' ? 'checked' : '' }} required class="sr-only peer">
                        <div class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all border-2 peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-800 border-slate-200 bg-white text-slate-500 hover:bg-amber-50 peer-checked:shadow-sm">
                            🤒 Sakit
                        </div>
                    </label>
                </div>
                @error('status')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Keterangan</label>
                <textarea name="notes" rows="3" required placeholder="Contoh: Izin acara keluarga / Sakit demam (surat dokter dilampirkan)"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 resize-none {{ $errors->has('notes') ? 'border-red-400 bg-red-50' : '' }}">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" id="btn-submit-permit"
                    class="bg-primary hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('btn-submit-permit').addEventListener('click', function() {
        const form = document.getElementById('permit-form');
        const status = form.querySelector('input[name="status"]:checked');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const label = status ? (status.value === 'Izin' ? 'IZIN' : 'SAKIT') : '-';

        Swal.fire({
            title: 'Konfirmasi Data',
            html: `Apakah Anda yakin ingin mencatat siswa ini sebagai <strong>${label}</strong>?<br><span class="text-xs text-slate-500">Data yang sudah disimpan dapat diubah melalui edit.</span>`,
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
                form.submit();
            }
        });
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#ef4444',
            customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl text-sm px-4 py-2' }
        });
    @endif
</script>
@endsection