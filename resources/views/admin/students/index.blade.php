@extends('layouts.app')

@section('title', 'Kelola Data Siswa')
@section('header_title', 'Siswa')

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
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <!-- Total Students -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Siswa</p>
                <h4 class="text-xl font-black text-slate-800 mt-0.5">{{ $stats['total'] }}</h4>
                <p class="text-[10px] text-slate-500 mt-0.5">Terdaftar</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Siswa Aktif</p>
                <h4 class="text-xl font-black text-emerald-700 mt-0.5">{{ $stats['active'] }}</h4>
                <p class="text-[10px] text-slate-500 mt-0.5">Siswa Presensi</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>

        <!-- Male Students -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Laki-laki (L)</p>
                <h4 class="text-xl font-black text-blue-700 mt-0.5">{{ $stats['male'] }}</h4>
                <p class="text-[10px] text-slate-500 mt-0.5">Siswa Putra</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </div>

        <!-- Female Students -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Perempuan (P)</p>
                <h4 class="text-xl font-black text-pink-700 mt-0.5">{{ $stats['female'] }}</h4>
                <p class="text-[10px] text-slate-500 mt-0.5">Siswa Putri</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center border border-pink-100 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter & Header Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 flex-1">
            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..."
                        class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary text-slate-800">
                </div>
            </div>

            <div>
                <select name="class_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary text-slate-800">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->academicYear->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="gender" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary text-slate-800">
                    <option value="">Semua Gender</option>
                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition-all">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'class_id', 'gender']))
                    <a href="{{ route('admin.students.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all border border-slate-200">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <button onclick="toggleModal('modal-create')" class="bg-primary hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-2 shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Siswa Baru</span>
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-4 px-6 w-16 text-center">Foto</th>
                        <th class="py-4 px-6">NISN</th>
                        <th class="py-4 px-6">Nama Lengkap Siswa</th>
                        <th class="py-4 px-6">Kelas</th>
                        <th class="py-4 px-6 text-center">Gender</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-3 px-6 text-center">
                                @if($student->photo_path)
                                    <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto Siswa" class="w-9 h-9 rounded-full object-cover border border-slate-200 mx-auto shadow-sm">
                                @else
                                    <div class="w-9 h-9 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center font-bold text-xs border border-slate-200 mx-auto shadow-sm">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-600 font-bold">{{ $student->nisn }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900 text-sm">
                                {{ $student->name }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold border border-slate-200">
                                    Kelas {{ $student->classRoom->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $student->gender == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Print Single QR Card -->
                                    <a href="{{ route('admin.qr-cards.print-single', $student->id) }}" target="_blank" title="Cetak Kartu QR Siswa" class="p-2 text-slate-500 hover:text-blue-600 rounded-xl hover:bg-blue-50 border border-slate-200 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                        </svg>
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('admin.students.edit', $student->id) }}" title="Edit Data Siswa" class="p-2 text-slate-500 hover:text-indigo-600 rounded-xl hover:bg-indigo-50 border border-slate-200 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Siswa" class="p-2 text-slate-500 hover:text-rose-600 rounded-xl hover:bg-rose-50 border border-slate-200 transition-all">
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
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Create -->
<div id="modal-create" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 transform transition-all max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-150 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="font-bold text-slate-800 text-sm">Tambah Siswa Baru</h3>
            <button onclick="toggleModal('modal-create')" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0081234567"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary text-slate-800 font-medium {{ $errors->has('nisn') ? 'border-rose-400 bg-rose-50' : '' }}">
                @error('nisn')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Lengkap Siswa</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Siswa"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary text-slate-800 font-medium {{ $errors->has('name') ? 'border-rose-400 bg-rose-50' : '' }}">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kelas</label>
                <select name="class_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary text-slate-800 font-medium {{ $errors->has('class_id') ? 'border-rose-400 bg-rose-50' : '' }}">
                    <option value="" disabled {{ old('class_id') ? '' : 'selected' }}>Pilih Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }} ({{ $class->academicYear->name ?? '-' }})</option>
                    @endforeach
                </select>
                @error('class_id')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center cursor-pointer text-sm text-slate-700 font-medium">
                        <input type="radio" name="gender" value="L" {{ old('gender', 'L') == 'L' ? 'checked' : '' }} required class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="flex items-center cursor-pointer text-sm text-slate-700 font-medium">
                        <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
                @error('gender')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Foto Profil (Opsional)</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/15 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-1 font-medium">Format JPG, PNG, atau JPEG. Maksimal 2MB.</p>
                @error('photo')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="toggleModal('modal-create')" class="px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold rounded-xl transition-all">Batal</button>
                <button type="submit" class="bg-primary hover:bg-slate-800 text-white px-5 py-2 rounded-xl text-xs font-bold transition-all shadow-sm">Simpan Data Siswa</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

    @if($errors->any())
        toggleModal('modal-create');
    @endif
</script>
@endsection