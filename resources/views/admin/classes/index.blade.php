@extends('layouts.app')

@section('title', 'Kelola Kelas')
@section('header_title', 'Kelas')

@section('content')
<div class="space-y-6">

    <!-- Flash Alert -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-2xl text-sm flex items-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2.5 flex-shrink-0 text-emerald-600">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.137-.089l4.003-5.604Z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Statistics Counter Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total Classes -->
        <div class="skeuo-stat-card rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Ruang Kelas</p>
                <h4 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['total_classes'] }}</h4>
                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">Rombongan Belajar</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center border border-blue-200 shadow-[inset_0_1px_0_#ffffff]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18" />
                </svg>
            </div>
        </div>

        <!-- Total Students -->
        <div class="skeuo-stat-card rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Siswa Terdaftar</p>
                <h4 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['total_students'] }}</h4>
                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">Siswa Aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200 shadow-[inset_0_1px_0_#ffffff]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
        </div>

        <!-- Homeroom Teachers Assigned -->
        <div class="skeuo-stat-card rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Wali Kelas Terisi</p>
                <h4 class="text-2xl font-extrabold text-indigo-900 mt-1">{{ $stats['teacher_assigned'] }} / {{ $stats['total_classes'] }}</h4>
                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">Penanggung Jawab Kelas</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-primary flex items-center justify-center border border-slate-200 shadow-[inset_0_1px_0_#ffffff]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter & Header Actions -->
    <div class="skeuo-card p-4 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.classes.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 flex-1">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas / wali kelas..."
                    class="w-full h-11 px-4 rounded-xl text-sm font-medium skeuo-input text-slate-800">
            </div>
            <div>
                <select name="academic_year_id" class="w-full h-11 px-4 rounded-xl text-sm font-medium skeuo-input text-slate-800 cursor-pointer">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($academicYears as $ay)
                        <option value="{{ $ay->id }}" {{ request('academic_year_id') == $ay->id ? 'selected' : '' }}>
                            {{ $ay->name }} {{ $ay->is_active ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full h-11 skeuo-btn skeuo-btn-secondary text-white rounded-xl text-sm font-bold shadow-md cursor-pointer">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'academic_year_id']))
                    <a href="{{ route('admin.classes.index') }}" class="px-4 h-11 skeuo-btn skeuo-btn-light text-slate-600 rounded-xl text-sm font-bold shadow-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <button onclick="toggleModal('modal-create')" class="skeuo-btn skeuo-btn-primary text-white h-11 px-5 rounded-xl text-sm font-bold shadow-md flex items-center space-x-2 shrink-0 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Kelas Baru</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="skeuo-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-4 px-6">Nama Kelas</th>
                        <th class="py-4 px-6">Tahun Ajaran</th>
                        <th class="py-4 px-6">Wali Kelas</th>
                        <th class="py-4 px-6 text-center">Jumlah Siswa</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($classes as $class)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-6 font-bold text-slate-900 text-sm">
                                {{ $class->name }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold border border-slate-200 shadow-[inset_0_1px_0_#ffffff]">
                                    {{ $class->academicYear->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                @if($class->homeroom_teacher)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-100 text-primary border border-slate-200 shadow-[inset_0_1px_0_#ffffff] flex items-center justify-center font-bold text-[10px]">
                                            {{ strtoupper(substr($class->homeroom_teacher, 0, 1)) }}
                                        </div>
                                        <span>{{ $class->homeroom_teacher }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum Ditentukan</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.04)] font-bold rounded-lg text-xs">
                                    {{ $class->students_count }} Siswa
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Print QR Class Shortcut -->
                                    <a href="{{ route('admin.qr-cards.print', $class->id) }}" target="_blank" title="Cetak Kartu QR Kelas" class="p-2 text-slate-500 hover:text-blue-700 rounded-xl hover:bg-blue-50 border border-slate-200 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.04)] transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                        </svg>
                                    </a>
                                    <!-- Edit -->
                                    <button onclick="openEditModal({{ json_encode($class) }})" title="Edit Kelas" class="p-2 text-slate-500 hover:text-indigo-700 rounded-xl hover:bg-indigo-50 border border-slate-200 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.04)] transition-all cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <!-- Delete -->
                                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Kelas" class="p-2 text-slate-500 hover:text-rose-600 rounded-xl hover:bg-rose-50 border border-slate-200 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.04)] transition-all cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data kelas terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($classes->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Create -->
<div id="modal-create" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="skeuo-card rounded-3xl max-w-md w-full overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-white/95 backdrop-blur-sm">
            <h3 class="font-extrabold text-slate-800 text-sm tracking-tight">Tambah Kelas Baru</h3>
            <button onclick="toggleModal('modal-create')" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.classes.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kelas</label>
                <input type="text" name="name" required placeholder="Contoh: VII-A" class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran</label>
                <select name="academic_year_id" required class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800 cursor-pointer">
                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Wali Kelas (Opsional)</label>
                <input type="text" name="homeroom_teacher" placeholder="Nama Guru Wali Kelas" class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800">
            </div>
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end space-x-2">
                <button type="button" onclick="toggleModal('modal-create')" class="px-4 py-2 skeuo-btn skeuo-btn-light text-slate-600 text-xs font-bold rounded-xl transition-all cursor-pointer">Batal</button>
                <button type="submit" class="skeuo-btn skeuo-btn-primary text-white px-5 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modal-edit" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="skeuo-card rounded-3xl max-w-md w-full overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-white/95 backdrop-blur-sm">
            <h3 class="font-extrabold text-slate-800 text-sm tracking-tight">Edit Data Kelas</h3>
            <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="form-edit" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kelas</label>
                <input type="text" name="name" id="edit-name" required placeholder="Contoh: VII-A" class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran</label>
                <select name="academic_year_id" id="edit-year-id" required class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800 cursor-pointer">
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Wali Kelas</label>
                <input type="text" name="homeroom_teacher" id="edit-teacher" placeholder="Nama Guru Wali Kelas" class="w-full px-4 py-2.5 rounded-xl text-sm font-medium skeuo-input text-slate-800">
            </div>
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end space-x-2">
                <button type="button" onclick="toggleModal('modal-edit')" class="px-4 py-2 skeuo-btn skeuo-btn-light text-slate-600 text-xs font-bold rounded-xl transition-all cursor-pointer">Batal</button>
                <button type="submit" class="skeuo-btn skeuo-btn-primary text-white px-5 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">Perbarui Kelas</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

    function openEditModal(classRoom) {
        document.getElementById('form-edit').action = `/admin/classes/${classRoom.id}`;
        document.getElementById('edit-name').value = classRoom.name;
        document.getElementById('edit-year-id').value = classRoom.academic_year_id;
        document.getElementById('edit-teacher').value = classRoom.homeroom_teacher || '';

        toggleModal('modal-edit');
    }
</script>
@endsection
