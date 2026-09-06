@extends('layouts.app')

@section('title', isset($user->id) ? 'Edit User' : 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Top Navigation & Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">
                {{ isset($user->id) ? 'Edit User Pengguna' : 'Tambah User Baru' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">
                {{ isset($user->id) ? 'Perbarui informasi akun dan hak akses pengguna' : 'Buat akun pengguna baru untuk Admin atau Petugas Piket' }}
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" 
           class="skeuo-btn skeuo-btn-light text-sm h-11 px-4 flex items-center space-x-1.5 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="skeuo-card p-6 sm:p-8">
        <form action="{{ isset($user->id) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" 
              method="POST" 
              class="space-y-5">
            @csrf
            @if(isset($user->id))
                @method('PUT')
            @endif

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name ?? '') }}" 
                       placeholder="Masukkan nama lengkap..."
                       required
                       class="skeuo-input font-medium text-slate-800 @error('name') !border-rose-500 @enderror">
                @error('name')
                    <p class="text-rose-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Username <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="{{ old('username', $user->username ?? '') }}" 
                       placeholder="Masukkan username untuk login..."
                       required
                       class="skeuo-input font-mono font-bold text-slate-800 @error('username') !border-rose-500 @enderror">
                @error('username')
                    <p class="text-rose-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Dropdown -->
            <div>
                <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Role Hak Akses <span class="text-rose-500">*</span>
                </label>
                <select id="role" 
                        name="role" 
                        required
                        class="skeuo-input font-semibold text-slate-800 @error('role') !border-rose-500 @enderror">
                    <option value="" disabled {{ old('role', $user->role ?? '') == '' ? 'selected' : '' }}>-- Pilih Role --</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                    <option value="piket" {{ old('role', $user->role ?? '') == 'piket' ? 'selected' : '' }}>Petugas Piket (Scanner & Dashboard Piket)</option>
                </select>
                @error('role')
                    <p class="text-rose-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Password {{ isset($user->id) ? '' : '*' }}
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="{{ isset($user->id) ? 'Masukkan password baru jika ingin mengubah' : 'Masukkan password akun (min. 6 karakter)...' }}"
                       {{ isset($user->id) ? '' : 'required' }}
                       class="skeuo-input font-medium text-slate-800 @error('password') !border-rose-500 @enderror">
                
                @if(isset($user->id))
                    <p class="text-slate-500 text-[11px] mt-1.5 flex items-center space-x-1 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <span>Kosongkan jika tidak ingin mengubah password.</span>
                    </p>
                @endif

                @error('password')
                    <p class="text-rose-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-200/80">
                <a href="{{ route('admin.users.index') }}" 
                   class="skeuo-btn skeuo-btn-light text-sm h-11 px-5 shadow-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="skeuo-btn skeuo-btn-primary text-sm h-11 px-6 shadow-md flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>{{ isset($user->id) ? 'Simpan Perubahan' : 'Tambah User' }}</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
