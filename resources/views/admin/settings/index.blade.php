@extends('layouts.app')

@section('title', 'Pengaturan Sistem & Branding')
@section('header_title', 'Pengaturan Aplikasi')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-2xl text-sm flex items-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-3 text-emerald-600 flex-shrink-0">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.137-.089l4.003-5.604Z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-2xl text-sm shadow-sm">
            <div class="font-semibold mb-1">Terjadi kesalahan pada input:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Branding & Identitas -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-3.015 1.833l-.11.318a1.875 1.875 0 0 1-1.745 1.272H2.25l-.17-.002a.75.75 0 0 1-.617-.962l.275-.824a5.25 5.25 0 0 1 4.97-3.633h1.822ZM15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3.75h-1.028a1.875 1.875 0 0 1-1.745-1.272l-.11-.318a3 3 0 0 0-3.016-1.833h-.624a5.25 5.25 0 0 1 4.97 3.633l.276.824a.75.75 0 0 1-.787.964H21a.75.75 0 0 0 0-1.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Branding & Identitas Aplikasi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola logo, nama aplikasi, subtitle, dan teks hak cipta aplikasi yang ditampilkan di Sidebar & Halaman Login.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Logo Upload Section with Live Preview -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Logo Aplikasi</label>
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 p-4 bg-slate-50/70 rounded-2xl border border-slate-200/70">
                        <!-- Preview Box -->
                        <div class="relative group flex-shrink-0">
                            <div class="w-24 h-24 bg-white border border-slate-200 rounded-2xl flex items-center justify-center overflow-hidden shadow-inner relative">
                                <img id="logo_preview" 
                                     src="{{ $appLogo && file_exists(public_path($appLogo)) ? asset($appLogo) : '' }}" 
                                     alt="Preview Logo" 
                                     class="max-w-full max-h-full object-contain p-2 {{ $appLogo && file_exists(public_path($appLogo)) ? '' : 'hidden' }}">
                                
                                <div id="logo_placeholder" class="text-slate-300 flex flex-col items-center justify-center p-2 {{ $appLogo && file_exists(public_path($appLogo)) ? 'hidden' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mb-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
                                    </svg>
                                    <span class="text-[10px] text-slate-400 font-medium">Tanpa Logo</span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Controls -->
                        <div class="space-y-3 flex-1 w-full">
                            <div class="flex flex-wrap items-center gap-3">
                                <label for="app_logo" class="cursor-pointer inline-flex items-center px-4 py-2.5 bg-primary hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-sm transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    Pilih Gambar Logo
                                </label>
                                <input type="file" name="app_logo" id="app_logo" accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml" class="hidden" onchange="previewImage(this)">

                                <label id="btn_remove_logo" class="inline-flex items-center px-3.5 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 rounded-xl text-xs font-semibold transition-all cursor-pointer {{ $appLogo ? '' : 'hidden' }}">
                                    <input type="checkbox" name="remove_logo" id="remove_logo" value="1" class="hidden" onchange="toggleRemoveLogo(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    <span id="remove_logo_text">Hapus Logo</span>
                                </label>
                            </div>

                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Format didukung: <span class="font-medium text-slate-700">PNG, JPG, WEBP, SVG</span>. Ukuran maks: <span class="font-medium text-slate-700">2 MB</span>. Disarankan rasio persegi (1:1) atau transparan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama Aplikasi -->
                    <div>
                        <label for="app_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Aplikasi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-3.015 1.833l-.11.318a1.875 1.875 0 0 1-1.745 1.272H2.25l-.17-.002a.75.75 0 0 1-.617-.962l.275-.824a5.25 5.25 0 0 1 4.97-3.633h1.822ZM15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3.75h-1.028a1.875 1.875 0 0 1-1.745-1.272l-.11-.318a3 3 0 0 0-3.016-1.833h-.624a5.25 5.25 0 0 1 4.97 3.633l.276.824a.75.75 0 0 1-.787.964H21a.75.75 0 0 0 0-1.5Z" />
                                </svg>
                            </span>
                            <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $appName) }}" required
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-semibold"
                                placeholder="Contoh: N-Presence">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Ditampilkan pada judul aplikasi, sidebar, dan header.</p>
                    </div>

                    <!-- Nama Sekolah -->
                    <div>
                        <label for="school_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Sekolah</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>
                            </span>
                            <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $schoolName) }}" required
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium"
                                placeholder="Contoh: SMP Negeri Nangtang">
                        </div>
                    </div>

                    <!-- Subtitle / Deskripsi -->
                    <div>
                        <label for="app_description" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Subtitle / Deskripsi Halaman Login</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </span>
                            <input type="text" name="app_description" id="app_description" value="{{ old('app_description', $appDescription) }}"
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800"
                                placeholder="Contoh: Sistem Absensi SMP Negeri Nangtang">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Keterangan singkat di bawah nama aplikasi pada halaman login.</p>
                    </div>

                    <!-- Teks Footer -->
                    <div>
                        <label for="app_footer" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Teks Footer Hak Cipta</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </span>
                            <input type="text" id="app_footer" value="{{ $appFooter }}" disabled
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed"
                                placeholder="Contoh: © 2026 KKN Kelompok 02 Nangtang. All rights reserved.">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Hak cipta sudah ditetapkan, tidak dapat diubah. Ditampilkan di bagian bawah login & footer halaman.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Jam Operasional Sekolah -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-500/10 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Konfigurasi Jam Operasional Absensi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Acuan perhitungan keterlambatan dan status kehadiran siswa harian.</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="time_in_limit" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Batas Jam Masuk</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                            <input type="time" name="time_in_limit" id="time_in_limit" value="{{ old('time_in_limit', $timeInLimit) }}" required
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Siswa yang scan sebelum jam ini dianggap hadir tepat waktu.</p>
                    </div>

                    <div>
                        <label for="time_in_tolerance" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Batas Toleransi (Terlambat)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                            <input type="time" name="time_in_tolerance" id="time_in_tolerance" value="{{ old('time_in_tolerance', $timeInTolerance) }}" required
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Siswa yang scan setelah jam ini otomatis dihitung terlambat.</p>
                    </div>

                    <div>
                        <label for="time_out_start" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Jam Mulai Scan Pulang</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                            <input type="time" name="time_out_start" id="time_out_start" value="{{ old('time_out_start', $timeOutStart ?? '13:00') }}" required
                                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Scan pulang baru diizinkan mulai dari jam ini.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex justify-end pt-2">
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-slate-800 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('logo_preview');
        const placeholder = document.getElementById('logo_placeholder');
        const removeBtn = document.getElementById('btn_remove_logo');
        const removeCheckbox = document.getElementById('remove_logo');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                removeBtn.classList.remove('hidden');
                
                if (removeCheckbox) {
                    removeCheckbox.checked = false;
                    document.getElementById('remove_logo_text').textContent = "Hapus Logo";
                    removeBtn.classList.remove('bg-red-100', 'border-red-400');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleRemoveLogo(checkbox) {
        const preview = document.getElementById('logo_preview');
        const placeholder = document.getElementById('logo_placeholder');
        const removeBtn = document.getElementById('btn_remove_logo');
        const removeText = document.getElementById('remove_logo_text');
        const fileInput = document.getElementById('app_logo');

        if (checkbox.checked) {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            fileInput.value = ''; // Reset file input
            removeText.textContent = "Logo Akan Dihapus";
            removeBtn.classList.add('bg-red-100', 'border-red-400');
        } else {
            if (preview.src && preview.src !== window.location.href) {
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            removeText.textContent = "Hapus Logo";
            removeBtn.classList.remove('bg-red-100', 'border-red-400');
        }
    }
</script>
@endsection
