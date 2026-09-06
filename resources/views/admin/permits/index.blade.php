@extends('layouts.app')

@section('title', 'Izin & Sakit')
@section('header_title', 'Manajemen Izin & Sakit')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'history', showProofModal: false, proofUrl: '', proofType: 'image' }">

    <!-- Header & Link Pengajuan Publik Slab -->
    <div class="bg-gradient-to-br from-[#182e4b] via-primary to-[#0f1d30] rounded-3xl p-6 text-white border-t border-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.25),0_10px_24px_-4px_rgba(15,23,42,0.35)] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-[11px] font-semibold text-blue-200 mb-2 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Modul Dispensasi</span>
            </div>
            <h2 class="text-xl font-black tracking-tight text-white drop-shadow-sm">Manajemen Izin & Sakit Siswa</h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl leading-relaxed">
                Catat dispensasi ketidakhadiran siswa karena izin/sakit dalam rentang tanggal tertentu, upload surat bukti dokter/izin, dan verifikasi pengajuan mandiri dari wali murid.
            </p>
        </div>
        <div class="flex items-center space-x-3 shrink-0">
            <a href="{{ route('public.permits.create') }}" target="_blank"
                class="skeuo-btn skeuo-btn-light text-xs py-2 px-3.5 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span>Buka Form Publik Wali</span>
            </a>
            <button onclick="copyPublicLink()" type="button"
                class="skeuo-btn skeuo-btn-secondary text-xs py-2 px-3.5 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.741c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                </svg>
                <span>Salin Link Publik</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="p-4 bg-gradient-to-r from-emerald-50 to-white border-l-4 border-emerald-500 text-emerald-900 rounded-2xl text-sm font-semibold flex items-center justify-between shadow-[0_2px_8px_rgba(16,185,129,0.12)]">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-gradient-to-r from-rose-50 to-white border-l-4 border-rose-500 text-rose-900 rounded-2xl text-sm font-semibold flex items-center justify-between shadow-[0_2px_8px_rgba(244,63,94,0.12)]">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Input Izin / Sakit (Multi-day Range & Upload) -->
    <div class="skeuo-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/80 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-primary/10 text-primary border border-primary/20 flex items-center justify-center font-bold shadow-[inset_0_1px_0_rgba(255,255,255,0.8)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 text-sm tracking-tight">Input Izin / Sakit Baru</h3>
                    <p class="text-xs text-slate-500 font-medium">Form pencatatan langsung oleh Admin atau Petugas Piket.</p>
                </div>
            </div>
        </div>

        <form id="permit-form" action="{{ route('admin.permits.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 items-end">
                <!-- Siswa -->
                <div class="lg:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Siswa</label>
                    <select name="student_id" required class="skeuo-input w-full font-semibold text-slate-800 text-sm">
                        <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->classRoom->name ?? '-' }}) — NISN: {{ $student->nisn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status (Izin / Sakit) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Dispensasi</label>
                    <div class="flex items-center space-x-3">
                        <label class="relative flex-1 cursor-pointer select-none">
                            <input type="radio" name="status" value="Izin" {{ old('status', 'Izin') == 'Izin' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full h-11 text-center px-4 rounded-xl text-xs font-bold transition-all border border-slate-300 bg-slate-100 hover:bg-slate-200/80 text-slate-700 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.05),0_2px_0_#cbd5e1] peer-checked:border-[#0f1d30] peer-checked:!bg-[#1e3a5f] peer-checked:!text-white peer-checked:shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] peer-checked:translate-y-[1px] flex items-center justify-center space-x-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <span>Izin</span>
                            </div>
                        </label>
                        <label class="relative flex-1 cursor-pointer select-none">
                            <input type="radio" name="status" value="Sakit" {{ old('status') == 'Sakit' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full h-11 text-center px-4 rounded-xl text-xs font-bold transition-all border border-slate-300 bg-slate-100 hover:bg-slate-200/80 text-slate-700 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.05),0_2px_0_#cbd5e1] peer-checked:border-amber-700 peer-checked:!bg-amber-600 peer-checked:!text-white peer-checked:shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] peer-checked:translate-y-[1px] flex items-center justify-center space-x-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                <span>Sakit</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- File Bukti Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Upload Bukti Surat (Opsional)</label>
                    <input type="file" name="attachment" accept="image/jpeg,image/png,image/webp,application/pdf"
                        class="skeuo-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-slate-800 transition-all cursor-pointer">
                </div>
            </div>

            <!-- Rentang Tanggal (Multi-day Range) & Keterangan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Dari Tanggal (Mulai)</label>
                    <input type="date" name="start_date" value="{{ old('start_date', now()->toDateString()) }}" required
                        class="skeuo-input w-full font-semibold text-slate-800 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sampai Tanggal (Selesai)</label>
                    <input type="date" name="end_date" value="{{ old('end_date', now()->toDateString()) }}" required
                        class="skeuo-input w-full font-semibold text-slate-800 text-sm">
                </div>
                <div class="sm:col-span-2 md:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan / Alasan</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" required placeholder="Contoh: Sakit demam / Acara keluarga"
                        class="skeuo-input w-full font-medium text-slate-800 text-sm">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200/80 flex justify-end">
                <button type="button" id="btn-submit-permit" class="skeuo-btn skeuo-btn-primary px-6 py-2.5 text-sm font-bold shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Simpan Data Izin / Sakit</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB NAVIGATION & DATA TABLES -->
    <div class="skeuo-card overflow-hidden">
        
        <!-- Tab Headers (Segmented Deck) -->
        <div class="flex border-b border-slate-200/80 bg-slate-100/60 p-2 gap-2 overflow-x-auto">
            <button @click="activeTab = 'history'" 
                :class="activeTab === 'history' ? 'bg-white text-primary shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.06)] border-slate-200 font-black' : 'text-slate-500 hover:text-slate-800 border-transparent font-bold'"
                class="px-5 py-2.5 rounded-xl text-xs border transition-all flex items-center space-x-2 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                <span>Riwayat & Ringkasan Izin / Sakit</span>
                <span class="skeuo-badge px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-700 font-black">{{ $permitsHistory->total() }}</span>
            </button>

            <button @click="activeTab = 'requests'" 
                :class="activeTab === 'requests' ? 'bg-white text-primary shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.06)] border-slate-200 font-black' : 'text-slate-500 hover:text-slate-800 border-transparent font-bold'"
                class="px-5 py-2.5 rounded-xl text-xs border transition-all flex items-center space-x-2 relative shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
                </svg>
                <span>Pengajuan Mandiri Wali Murid</span>
                @if(count($pendingRequests) > 0)
                    <span class="skeuo-badge px-2 py-0.5 rounded-full text-[10px] bg-amber-500 text-white font-black animate-pulse">{{ count($pendingRequests) }} Baru</span>
                @else
                    <span class="skeuo-badge px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-600 font-bold">0</span>
                @endif
            </button>
        </div>

        <!-- TAB 1: RIWAYAT IZIN & SAKIT -->
        <div x-show="activeTab === 'history'" class="p-6 space-y-6">
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('admin.permits.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 skeuo-inset p-4 rounded-2xl">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Mulai Tanggal</label>
                    <input type="date" name="filter_start_date" value="{{ request('filter_start_date') }}"
                        class="skeuo-input text-xs py-2 px-3">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="filter_end_date" value="{{ request('filter_end_date') }}"
                        class="skeuo-input text-xs py-2 px-3">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Filter Kelas</label>
                    <select name="filter_class_id" class="skeuo-input text-xs py-2 px-3">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($classRooms as $cls)
                            <option value="{{ $cls->id }}" {{ request('filter_class_id') == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Status</label>
                    <select name="filter_status" class="skeuo-input text-xs py-2 px-3">
                        <option value="">-- Semua Status --</option>
                        <option value="Izin" {{ request('filter_status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ request('filter_status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama/NISN..."
                        class="skeuo-input text-xs py-2 px-3">
                    <button type="submit" class="skeuo-btn skeuo-btn-primary text-xs py-2 px-3.5 shrink-0">
                        Filter
                    </button>
                    @if(request()->anyFilled(['filter_start_date', 'filter_end_date', 'filter_class_id', 'filter_status', 'search']))
                        <a href="{{ route('admin.permits.index') }}" class="skeuo-btn skeuo-btn-light text-xs py-2 px-3 shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl shadow-sm">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100/70 text-slate-600 font-black uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Siswa</th>
                            <th class="px-5 py-3.5">Kelas</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Keterangan</th>
                            <th class="px-5 py-3.5 text-center">Bukti Surat</th>
                            <th class="px-5 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($permitsHistory as $item)
                            <tr class="hover:bg-blue-50/30 transition-all">
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-800 font-black text-xs">
                                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-black text-slate-800 text-sm tracking-tight">{{ $item->student->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400 font-mono font-semibold">NISN: {{ $item->student->nisn ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="skeuo-badge px-2.5 py-1 bg-slate-100 text-slate-700 font-bold text-xs">
                                        {{ $item->student->classRoom->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($item->status == 'Izin')
                                        <span class="skeuo-badge px-3 py-1 bg-blue-50 text-blue-800 border-blue-300 font-black text-xs shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(59,130,246,0.15)] inline-flex items-center space-x-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                            <span>Izin</span>
                                        </span>
                                    @else
                                        <span class="skeuo-badge px-3 py-1 bg-amber-50 text-amber-800 border-amber-300 font-black text-xs shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)] inline-flex items-center space-x-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                            </svg>
                                            <span>Sakit</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 max-w-xs truncate text-xs text-slate-600 font-medium">
                                    {{ $item->notes ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($item->attachment)
                                        <button type="button" 
                                            @click="proofUrl = '{{ asset($item->attachment) }}'; proofType = '{{ str_ends_with(strtolower($item->attachment), '.pdf') ? 'pdf' : 'image' }}'; showProofModal = true"
                                            class="skeuo-btn skeuo-btn-light text-xs py-1 px-2.5 inline-flex items-center space-x-1 font-bold text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                            <span>Lihat Surat</span>
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tanpa File</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <form action="{{ route('admin.permits.destroy', $item->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi izin/sakit ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-all" title="Hapus Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-slate-400 text-sm">
                                    Belum ada data riwayat izin atau sakit yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div>
                {{ $permitsHistory->links() }}
            </div>
        </div>

        <!-- TAB 2: PENGAJUAN MANDIRI WALI MURID (PENDING) -->
        <div x-show="activeTab === 'requests'" class="p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-gradient-to-r from-amber-50 to-white border border-amber-300 p-4 rounded-2xl text-amber-900 shadow-[inset_0_1px_0_#ffffff,0_2px_6px_rgba(245,158,11,0.08)] gap-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-black text-sm tracking-tight text-amber-900">Permohonan Izin / Sakit Masuk Dari Wali Murid</h4>
                        <p class="text-xs text-amber-700 font-medium">Tinjau permohonan di bawah ini. Tombol 'Setujui' akan otomatis mencatat absensi siswa sesuai rentang tanggal yang diajukan.</p>
                    </div>
                </div>
                <span class="skeuo-badge px-3 py-1 bg-amber-500 text-white font-black text-xs shrink-0 shadow-sm">
                    {{ count($pendingRequests) }} Menunggu Persetujuan
                </span>
            </div>

            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl shadow-sm">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100/70 text-slate-600 font-black uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3.5">Tgl Pengajuan</th>
                            <th class="px-5 py-3.5">Siswa & Kelas</th>
                            <th class="px-5 py-3.5">Wali Murid</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Rentang Tanggal</th>
                            <th class="px-5 py-3.5">Keterangan</th>
                            <th class="px-5 py-3.5 text-center">Bukti Surat</th>
                            <th class="px-5 py-3.5 text-center">Aksi Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($pendingRequests as $req)
                            <tr class="hover:bg-blue-50/30 transition-all">
                                <td class="px-5 py-3.5 text-xs text-slate-500 whitespace-nowrap font-mono">
                                    {{ $req->created_at->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-black text-slate-800 text-sm tracking-tight">{{ $req->student->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 font-semibold">Kelas {{ $req->student->classRoom->name ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs">
                                    <div class="font-black text-slate-800">{{ $req->parent_name }}</div>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $req->parent_phone) }}" target="_blank" class="text-emerald-600 hover:underline flex items-center space-x-1 mt-0.5 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                        </svg>
                                        <span>{{ $req->parent_phone }}</span>
                                    </a>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($req->status_type == 'Izin')
                                        <span class="skeuo-badge px-3 py-1 bg-blue-50 text-blue-800 border-blue-300 font-black text-xs inline-flex items-center space-x-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                            <span>Izin</span>
                                        </span>
                                    @else
                                        <span class="skeuo-badge px-3 py-1 bg-amber-50 text-amber-800 border-amber-300 font-black text-xs inline-flex items-center space-x-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                            </svg>
                                            <span>Sakit</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-xs font-bold text-slate-800">
                                    {{ $req->start_date->translatedFormat('d M') }} s/d {{ $req->end_date->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs max-w-xs truncate text-slate-600 font-medium">
                                    {{ $req->notes }}
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    @if($req->attachment)
                                        <button type="button" 
                                            @click="proofUrl = '{{ asset($req->attachment) }}'; proofType = '{{ str_ends_with(strtolower($req->attachment), '.pdf') ? 'pdf' : 'image' }}'; showProofModal = true"
                                            class="skeuo-btn skeuo-btn-light text-xs py-1 px-2.5 inline-flex items-center space-x-1 font-bold text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                            <span>Lihat Surat</span>
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tanpa File</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="{{ route('admin.permits.approve', $req->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="skeuo-btn skeuo-btn-success text-xs py-1.5 px-3 flex items-center space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.permits.reject', $req->id) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menolak pengajuan izin ini?')">
                                            @csrf
                                            <button type="submit" class="skeuo-btn skeuo-btn-danger text-xs py-1.5 px-3 flex items-center space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-8 text-center text-slate-400 text-sm">
                                    Tidak ada pengajuan izin/sakit mandiri yang sedang menunggu persetujuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- MODAL PREVIEW SURAT BUKTI (Tactile Beveled Dialog) -->
    <div x-show="showProofModal" x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4 overflow-y-auto"
        @keydown.escape.window="showProofModal = false">
        <div class="skeuo-card max-w-2xl w-full overflow-hidden shadow-2xl !p-0" @click.away="showProofModal = false">
            <div class="px-6 py-4 border-b border-slate-200/80 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                <h3 class="font-black text-slate-800 text-sm tracking-tight">Pratinjau Surat Bukti Izin / Dokter</h3>
                <button type="button" @click="showProofModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 text-center max-h-[75vh] overflow-y-auto skeuo-inset">
                <template x-if="proofType === 'image'">
                    <img :src="proofUrl" alt="Surat Bukti" class="max-w-full max-h-[60vh] mx-auto rounded-xl shadow-md border border-slate-200 object-contain">
                </template>
                <template x-if="proofType === 'pdf'">
                    <iframe :src="proofUrl" class="w-full h-[60vh] rounded-xl border border-slate-200"></iframe>
                </template>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200/80 flex justify-between items-center">
                <a :href="proofUrl" target="_blank" download class="inline-flex items-center space-x-1.5 text-xs font-bold text-primary hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Download File Asli</span>
                </a>
                <button type="button" @click="showProofModal = false" class="skeuo-btn skeuo-btn-light text-xs py-1.5 px-4">
                    Tutup
                </button>
            </div>
        </div>
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
            title: 'Konfirmasi Data Izin/Sakit',
            html: `Apakah Anda yakin ingin mencatat data <strong>${label}</strong> ini?<br><span class="text-xs text-slate-500">Sistem akan otomatis mencatat absensi siswa sesuai rentang tanggal yang dipilih.</span>`,
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

    function copyPublicLink() {
        const url = "{{ route('public.permits.create') }}";
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Link Berhasil Disalin!',
                text: 'URL Form Pengajuan Izin Wali Murid telah disalin ke clipboard.',
                timer: 2000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-3xl' }
            });
        });
    }
</script>
@endsection