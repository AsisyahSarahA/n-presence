@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('header_title', 'Tambah Siswa')

@section('content')
<div class="max-w-xl">
    <!-- Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-150 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-lg">Input Data Siswa Baru</h3>
            <a href="{{ route('admin.students.index') }}" class="text-xs text-slate-500 hover:text-slate-700 font-semibold transition-all">Kembali</a>
        </div>
        
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0081234567"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                @error('nisn')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Siswa"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kelas</label>
                <select name="class_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->academicYear->name }})
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center cursor-pointer text-sm text-slate-700">
                        <input type="radio" name="gender" value="L" {{ old('gender') == 'L' ? 'checked' : '' }} required class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="flex items-center cursor-pointer text-sm text-slate-700">
                        <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
                @error('gender')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Foto Profil (Opsional)</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/15 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-1">Format JPG, PNG, atau JPEG. Ukuran file maksimal 2MB.</p>
                @error('photo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-2">
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 border border-slate-200 text-slate-500 hover:bg-slate-50 text-sm font-semibold rounded-xl transition-all">Batal</a>
                <button type="submit" class="bg-primary hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm">
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
