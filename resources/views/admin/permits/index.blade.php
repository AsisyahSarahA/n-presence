@extends('layouts.app')

@section('title', 'Izin & Sakit')
@section('header_title', 'Manajemen Izin & Sakit')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'history', showProofModal: false, proofUrl: '', proofType: 'image' }">

    <!-- Header & Link Pengajuan Publik -->
    <div class="bg-gradient-to-r from-primary to-slate-800 rounded-3xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-wide">Manajemen Izin & Sakit Siswa</h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">
                Catat ketidakhadiran siswa karena izin/sakit dalam rentang tanggal tertentu, upload surat bukti dokter/izin, dan kelola pengajuan mandiri dari orang tua murid.
            </p>
        </div>
        <div class="flex items-center space-x-3 shrink-0">
            <a href="{{ route('public.permits.create') }}" target="_blank"
                class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span>Buka Form Publik Wali</span>
            </a>
            <button onclick="copyPublicLink()" type="button"
                class="bg-secondary hover:bg-blue-600 text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition-all shadow-sm flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.741c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                </svg>
                <span>Salin Link Publik</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-2xl text-sm font-semibold flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-2xl text-sm font-semibold flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Input Izin / Sakit (Multi-day Range & Upload) -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-150 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                    ✍️
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Input Izin / Sakit Baru</h3>
                    <p class="text-xs text-slate-500">Form pengisian langsung oleh Admin / Petugas Piket.</p>
                </div>
            </div>
        </div>

        <form id="permit-form" action="{{ route('admin.permits.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- Siswa -->
                <div class="lg:col-span-1">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Siswa</label>
                    <select name="student_id" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                        <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>Pilih Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->classRoom->name ?? '-' }}) — NISN: {{ $student->nisn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status (Izin / Sakit) -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Status Ketidakhadiran</label>
                    <div class="flex items-center space-x-3">
                        <label class="relative flex-1 cursor-pointer">
                            <input type="radio" name="status" value="Izin" {{ old('status', 'Izin') == 'Izin' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full text-center py-2.5 px-3 rounded-xl text-xs font-bold transition-all border-2 border-slate-200 bg-white text-slate-600 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary hover:bg-slate-50">
                                ✉️ Izin
                            </div>
                        </label>
                        <label class="relative flex-1 cursor-pointer">
                            <input type="radio" name="status" value="Sakit" {{ old('status') == 'Sakit' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full text-center py-2.5 px-3 rounded-xl text-xs font-bold transition-all border-2 border-slate-200 bg-white text-slate-600 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-800 hover:bg-slate-50">
                                🤒 Sakit
                            </div>
                        </label>
                    </div>
                </div>

                <!-- File Bukti Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Upload Bukti Surat (Opsional)</label>
                    <input type="file" name="attachment" accept="image/jpeg,image/png,image/webp,application/pdf"
                        class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-slate-800 transition-all cursor-pointer">
                </div>
            </div>

            <!-- Rentang Tanggal (Multi-day Range) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Dari Tanggal (Mulai)</label>
                    <input type="date" name="start_date" value="{{ old('start_date', now()->toDateString()) }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Sampai Tanggal (Selesai)</label>
                    <input type="date" name="end_date" value="{{ old('end_date', now()->toDateString()) }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                </div>
                <div class="sm:col-span-2 md:col-span-1">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Keterangan / Alasan</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" required placeholder="Contoh: Sakit demam / Acara keluarga"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="button" id="btn-submit-permit"
                    class="bg-primary hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md hover:shadow-lg flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Simpan Data Izin / Sakit</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TAB NAVIGATION & DATA TABLES -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        
        <!-- Tab Headers -->
        <div class="flex border-b border-slate-200 bg-slate-50/70 px-6 pt-3 space-x-3 overflow-x-auto">
            <button @click="activeTab = 'history'" 
                :class="activeTab === 'history' ? 'border-primary text-primary bg-white shadow-sm font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="px-5 py-3 border-b-2 rounded-t-2xl text-sm transition-all flex items-center space-x-2 shrink-0">
                <span>📋 Riwayat & Ringkasan Izin / Sakit</span>
                <span class="px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-700 font-bold">{{ $permitsHistory->total() }}</span>
            </button>

            <button @click="activeTab = 'requests'" 
                :class="activeTab === 'requests' ? 'border-primary text-primary bg-white shadow-sm font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                class="px-5 py-3 border-b-2 rounded-t-2xl text-sm transition-all flex items-center space-x-2 relative shrink-0">
                <span>📩 Pengajuan Mandiri Wali Murid</span>
                @if(count($pendingRequests) > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs bg-amber-500 text-white font-bold animate-pulse">{{ count($pendingRequests) }} Baru</span>
                @else
                    <span class="px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-600 font-bold">0</span>
                @endif
            </button>
        </div>

        <!-- TAB 1: RIWAYAT IZIN & SAKIT -->
        <div x-show="activeTab === 'history'" class="p-6 space-y-6">
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('admin.permits.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Mulai Tanggal</label>
                    <input type="date" name="filter_start_date" value="{{ request('filter_start_date') }}"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="filter_end_date" value="{{ request('filter_end_date') }}"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Filter Kelas</label>
                    <select name="filter_class_id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($classRooms as $cls)
                            <option value="{{ $cls->id }}" {{ request('filter_class_id') == $cls->id ? 'selected' : '' }}>Kelas {{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status</label>
                    <select name="filter_status" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Status --</option>
                        <option value="Izin" {{ request('filter_status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ request('filter_status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama/NISN..."
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary">
                    <button type="submit" class="bg-primary hover:bg-slate-800 text-white px-3 py-2 rounded-xl text-xs font-semibold shrink-0">
                        Filter
                    </button>
                    @if(request()->anyFilled(['filter_start_date', 'filter_end_date', 'filter_class_id', 'filter_status', 'search']))
                        <a href="{{ route('admin.permits.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2 rounded-xl text-xs font-semibold shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Siswa</th>
                            <th class="px-5 py-3">Kelas</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Keterangan</th>
                            <th class="px-5 py-3 text-center">Bukti Surat</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($permitsHistory as $item)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-800 font-bold">
                                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-semibold text-slate-800">{{ $item->student->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">NISN: {{ $item->student->nisn ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold">
                                        {{ $item->student->classRoom->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($item->status == 'Izin')
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200/60 rounded-xl text-xs font-bold">
                                            ✉️ Izin
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200/60 rounded-xl text-xs font-bold">
                                            🤒 Sakit
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 max-w-xs truncate text-xs text-slate-600">
                                    {{ $item->notes ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($item->attachment)
                                        <button type="button" 
                                            @click="proofUrl = '{{ asset($item->attachment) }}'; proofType = '{{ str_ends_with(strtolower($item->attachment), '.pdf') ? 'pdf' : 'image' }}'; showProofModal = true"
                                            class="inline-flex items-center space-x-1 text-xs font-semibold text-primary hover:text-blue-700 underline bg-primary/5 hover:bg-primary/10 px-2.5 py-1 rounded-lg transition-all">
                                            <span>📄 Lihat Surat</span>
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
                                        <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all" title="Hapus Data">
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
            <div class="flex items-center justify-between bg-amber-50 border border-amber-200/80 p-4 rounded-2xl text-amber-900">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">📥</span>
                    <div>
                        <h4 class="font-bold text-sm">Permohonan Izin / Sakit Masuk Dari Wali Murid</h4>
                        <p class="text-xs text-amber-700">Tinjau permohonan di bawah ini. Tombol 'Setujui' akan otomatis mencatat absensi siswa sesuai rentang tanggal yang diajukan.</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-amber-200 text-amber-900 font-bold rounded-xl text-xs">
                    {{ count($pendingRequests) }} Menunggu Persetujuan
                </span>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">Tgl Pengajuan</th>
                            <th class="px-5 py-3">Siswa & Kelas</th>
                            <th class="px-5 py-3">Wali Murid</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Rentang Tanggal</th>
                            <th class="px-5 py-3">Keterangan</th>
                            <th class="px-5 py-3 text-center">Bukti Surat</th>
                            <th class="px-5 py-3 text-center">Aksi Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($pendingRequests as $req)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="px-5 py-3.5 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $req->created_at->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-semibold text-slate-800">{{ $req->student->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-500">Kelas {{ $req->student->classRoom->name ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs">
                                    <div class="font-bold text-slate-700">{{ $req->parent_name }}</div>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $req->parent_phone) }}" target="_blank" class="text-emerald-600 hover:underline flex items-center space-x-1 mt-0.5">
                                        <span>💬 {{ $req->parent_phone }}</span>
                                    </a>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($req->status_type == 'Izin')
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg text-xs font-bold">
                                            ✉️ Izin
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-xs font-bold">
                                            🤒 Sakit
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-xs font-semibold text-slate-800">
                                    {{ $req->start_date->translatedFormat('d M') }} s/d {{ $req->end_date->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5 text-xs max-w-xs truncate text-slate-600">
                                    {{ $req->notes }}
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    @if($req->attachment)
                                        <button type="button" 
                                            @click="proofUrl = '{{ asset($req->attachment) }}'; proofType = '{{ str_ends_with(strtolower($req->attachment), '.pdf') ? 'pdf' : 'image' }}'; showProofModal = true"
                                            class="inline-flex items-center space-x-1 text-xs font-semibold text-primary hover:text-blue-700 underline bg-primary/5 hover:bg-primary/10 px-2.5 py-1 rounded-lg transition-all">
                                            <span>📄 Lihat Surat</span>
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tanpa File</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="{{ route('admin.permits.approve', $req->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-xl text-xs font-semibold transition-all shadow-sm flex items-center space-x-1">
                                                <span>✓ Setujui</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.permits.reject', $req->id) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menolak pengajuan izin ini?')">
                                            @csrf
                                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-xl text-xs font-semibold transition-all flex items-center space-x-1">
                                                <span>✕ Tolak</span>
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

    <!-- MODAL PREVIEW SURAT BUKTI -->
    <div x-show="showProofModal" x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 overflow-y-auto"
        @keydown.escape.window="showProofModal = false">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden border border-slate-100" @click.away="showProofModal = false">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-bold text-slate-800 text-sm">Pratinjau Surat Bukti Izin / Dokter</h3>
                <button type="button" @click="showProofModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 text-center max-h-[75vh] overflow-y-auto">
                <template x-if="proofType === 'image'">
                    <img :src="proofUrl" alt="Surat Bukti" class="max-w-full max-h-[60vh] mx-auto rounded-xl shadow-md border border-slate-200 object-contain">
                </template>
                <template x-if="proofType === 'pdf'">
                    <iframe :src="proofUrl" class="w-full h-[60vh] rounded-xl border border-slate-200"></iframe>
                </template>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                <a :href="proofUrl" target="_blank" download class="text-xs font-semibold text-primary hover:underline">
                    📥 Download File Asli
                </a>
                <button type="button" @click="showProofModal = false" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-xl text-xs font-semibold">
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