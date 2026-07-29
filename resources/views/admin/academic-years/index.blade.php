@extends('layouts.app')

@section('title', 'Kelola Tahun Ajaran')
@section('header_title', 'Tahun Ajaran')

@section('content')
<div class="space-y-6">

    <!-- Flash Alerts -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-2xl text-sm flex items-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2.5 flex-shrink-0 text-emerald-600">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.137-.089l4.003-5.604Z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-2xl text-sm flex items-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2.5 flex-shrink-0 text-rose-600">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Statistics Counter Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total Years -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Periode</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total'] }}</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Tahun Ajaran Terdaftar</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
        </div>

        <!-- Active Year -->
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Tahun Ajaran Aktif</p>
                <h4 class="text-xl font-black text-emerald-900 mt-1">
                    {{ $stats['active'] ? $stats['active']->name : 'Belum Ada' }}
                </h4>
                <p class="text-[11px] text-emerald-700 mt-0.5">Status Pengguna Sistem</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>

        <!-- Inactive Count -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Arsip Non-Aktif</p>
                <h4 class="text-2xl font-black text-slate-700 mt-1">{{ $stats['inactive'] }}</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Tahun Ajaran Lalu</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center border border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-16.5 0-.75-3h18l-.75 3" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Header Actions & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.academic-years.index') }}" class="flex items-center space-x-2 flex-1">
            <div class="relative w-full max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tahun ajaran (contoh: 2026/2027)..."
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
            </div>
            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-semibold transition-all">
                Cari
            </button>
        </form>

        <button onclick="toggleModal('modal-create')" class="bg-primary hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-2 shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Tahun Ajaran</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-4 px-6">Tahun Ajaran</th>
                        <th class="py-4 px-6">Tanggal Mulai</th>
                        <th class="py-4 px-6">Tanggal Selesai</th>
                        <th class="py-4 px-6 text-center">Jumlah Kelas</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($years as $year)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $year->name }}</div>
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-600">{{ $year->start_date->format('d M Y') }}</td>
                            <td class="py-4 px-6 font-mono text-slate-600">{{ $year->end_date->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-[11px]">
                                    {{ $year->classes_count }} Kelas
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($year->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 mr-1 text-emerald-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="openEditModal({{ json_encode($year) }})" title="Edit Tahun Ajaran" class="p-2 text-slate-500 hover:text-indigo-600 rounded-xl hover:bg-indigo-50 border border-slate-200 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    @if(!$year->is_active)
                                        <form action="{{ route('admin.academic-years.destroy', $year->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Tahun Ajaran" class="p-2 text-slate-500 hover:text-rose-600 rounded-xl hover:bg-rose-50 border border-slate-200 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data tahun ajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($years->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $years->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Create -->
<div id="modal-create" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-150 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-sm">Tambah Tahun Ajaran Baru</h3>
            <button onclick="toggleModal('modal-create')" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.academic-years.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Tahun Ajaran</label>
                <input type="text" name="name" required placeholder="Contoh: 2026/2027" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all text-slate-800 font-medium">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="start_date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all text-slate-800 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="end_date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all text-slate-800 font-medium">
                </div>
            </div>
            <div class="flex items-center pt-2">
                <input type="checkbox" name="is_active" id="create-active" value="1" class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                <label for="create-active" class="ml-2 text-xs font-medium text-slate-600">Jadikan Aktif (Otomatis menonaktifkan tahun ajaran lainnya)</label>
            </div>
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="toggleModal('modal-create')" class="px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold rounded-xl transition-all">Batal</button>
                <button type="submit" class="px-5 py-2 bg-primary hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all">Simpan Periode</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modal-edit" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-150 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-sm">Edit Tahun Ajaran</h3>
            <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="form-edit" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Tahun Ajaran</label>
                <input type="text" name="name" id="edit-name" required placeholder="Contoh: 2026/2027" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all text-slate-800 font-medium">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="edit-start" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all text-slate-800 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="edit-end" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all text-slate-800 font-medium">
                </div>
            </div>
            <div class="flex items-center pt-2">
                <input type="checkbox" name="is_active" id="edit-active" value="1" class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                <label for="edit-active" class="ml-2 text-xs font-medium text-slate-600">Jadikan Aktif (Otomatis menonaktifkan tahun ajaran lainnya)</label>
            </div>
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="toggleModal('modal-edit')" class="px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold rounded-xl transition-all">Batal</button>
                <button type="submit" class="px-5 py-2 bg-primary hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all">Perbarui Periode</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

    function openEditModal(year) {
        document.getElementById('form-edit').action = `/admin/academic-years/${year.id}`;
        document.getElementById('edit-name').value = year.name;
        
        const start = new Date(year.start_date).toISOString().split('T')[0];
        const end = new Date(year.end_date).toISOString().split('T')[0];
        
        document.getElementById('edit-start').value = start;
        document.getElementById('edit-end').value = end;
        document.getElementById('edit-active').checked = year.is_active;

        toggleModal('modal-edit');
    }
</script>
@endsection
