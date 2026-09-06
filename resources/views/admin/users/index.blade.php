@extends('layouts.app')

@section('title', 'Kelola User Pengguna')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 skeuo-card p-6">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-[11px] font-bold text-primary mb-2 shadow-[inset_0_1px_0_rgba(255,255,255,0.8)]">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                <span>Hak Akses Sistem</span>
            </div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">Manajemen User</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Kelola akun pengguna sistem (Administrator & Petugas Piket)</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" 
               class="skeuo-btn skeuo-btn-primary text-sm h-11 px-5 flex items-center space-x-2 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah User Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="skeuo-card p-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama atau username..." 
                       class="skeuo-input w-full h-11 pl-10 pr-4 text-sm font-semibold text-slate-800 placeholder:font-normal">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="skeuo-btn skeuo-btn-primary text-sm h-11 px-5 shadow-md">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="skeuo-btn skeuo-btn-light text-sm h-11 px-4 shadow-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="skeuo-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-100/70 text-slate-600 uppercase text-[10px] font-black border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Lengkap</th>
                        <th class="py-3.5 px-4">Username</th>
                        <th class="py-3.5 px-4 text-center">Role Akses</th>
                        <th class="py-3.5 px-4">Tanggal Dibuat</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $idx => $u)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-mono font-bold">
                                {{ $users->firstItem() + $idx }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-b from-white to-slate-100 text-slate-700 font-black flex items-center justify-center border border-slate-200 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(0,0,0,0.05)]">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <span class="font-black text-slate-900 tracking-tight text-sm">{{ $u->name }}</span>
                                    @if(Auth::id() == $u->id)
                                        <span class="skeuo-badge bg-primary/10 text-primary border-primary/20 text-[10px] px-2 py-0.5 font-bold">Anda</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-600">
                                {{ $u->username }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($u->role === 'admin')
                                    <span class="skeuo-badge inline-flex items-center space-x-1 px-2.5 py-1 text-[11px] font-black bg-purple-50 text-purple-800 border-purple-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(168,85,247,0.15)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                        </svg>
                                        <span>Admin</span>
                                    </span>
                                @else
                                    <span class="skeuo-badge inline-flex items-center space-x-1 px-2.5 py-1 text-[11px] font-black bg-blue-50 text-blue-800 border-blue-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(59,130,246,0.15)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002A11.386 11.386 0 0 1 5.077 19.24v-.111c0-1.113.285-2.16.786-3.07M15 19.128v.11a11.386 11.386 0 0 1-4.914 1.107A11.378 11.378 0 0 1 5.08 19.24M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM6 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                        </svg>
                                        <span>Petugas Piket</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-medium">
                                {{ $u->created_at ? $u->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $u->id) }}" 
                                       title="Edit User"
                                       class="skeuo-btn skeuo-btn-light !p-2 !rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    @if(Auth::id() != $u->id)
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    title="Hapus User"
                                                    class="p-2 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-xl transition-all">
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
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                Belum ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
