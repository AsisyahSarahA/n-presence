@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('header_title', 'Tambah Siswa')

@section('content')
<div class="max-w-xl">
    <!-- Form Card -->
    <div class="skeuo-card rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-extrabold text-slate-800 text-base tracking-tight">Input Data Siswa Baru</h3>
            <a href="{{ route('admin.students.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-bold transition-all">Kembali</a>
        </div>
        
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0081234567"
                    class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800">
                @error('nisn')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Siswa"
                    class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kelas</label>
                <select name="class_id" required class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800 cursor-pointer">
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->academicYear->name }})
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center cursor-pointer text-sm text-slate-700 font-semibold select-none">
                        <input type="radio" name="gender" value="L" {{ old('gender', 'L') == 'L' ? 'checked' : '' }} required class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="flex items-center cursor-pointer text-sm text-slate-700 font-semibold select-none">
                        <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
                @error('gender')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Profil (Opsional)</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-4 py-2 rounded-xl text-sm skeuo-input text-slate-600 file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:brightness-105 cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-1 font-medium">Format JPG, PNG, atau JPEG. Ukuran file maksimal 2MB.</p>
                @error('photo')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end space-x-3">
                <a href="{{ route('admin.students.index') }}" class="skeuo-btn skeuo-btn-light text-slate-600 text-sm h-11 px-5 font-bold rounded-xl shadow-sm">Batal</a>
                <button type="submit" class="skeuo-btn skeuo-btn-primary text-white h-11 px-6 text-sm font-bold rounded-xl shadow-md cursor-pointer">
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
