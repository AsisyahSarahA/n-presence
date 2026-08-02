@extends('layouts.app')

@section('title', isset($user->id) ? 'Edit User' : 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Top Navigation & Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                {{ isset($user->id) ? 'Edit User Pengguna' : 'Tambah User Baru' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                {{ isset($user->id) ? 'Perbarui informasi akun dan hak akses pengguna' : 'Buat akun pengguna baru untuk Admin atau Petugas Piket' }}
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center space-x-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition-all border border-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
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
                       class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
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
                       class="w-full px-4 py-2.5 text-xs font-mono border border-slate-300 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all @error('username') border-rose-500 @enderror">
                @error('username')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
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
                        class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all @error('role') border-rose-500 @enderror">
                    <option value="" disabled {{ old('role', $user->role ?? '') == '' ? 'selected' : '' }}>-- Pilih Role --</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>🛡️ Administrator (Akses Penuh)</option>
                    <option value="piket" {{ old('role', $user->role ?? '') == 'piket' ? 'selected' : '' }}>📋 Petugas Piket (Scanner & Dashboard Piket)</option>
                </select>
                @error('role')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
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
                       class="w-full px-4 py-2.5 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all @error('password') border-rose-500 @enderror">
                
                @if(isset($user->id))
                    <p class="text-slate-500 text-[11px] mt-1.5 flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <span>Kosongkan jika tidak ingin mengubah password.</span>
                    </p>
                @endif

                @error('password')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-[#1e3a5f] hover:bg-[#111e30] text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>{{ isset($user->id) ? 'Simpan Perubahan' : 'Tambah User' }}</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
