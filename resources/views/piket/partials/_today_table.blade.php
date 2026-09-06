<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse text-xs">
        <thead>
            <tr class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                <th class="py-3.5 px-4 w-10 text-center">No</th>
                <th class="py-3.5 px-4">Nama Siswa</th>
                <th class="py-3.5 px-4 text-center">Kelas</th>
                <th class="py-3.5 px-4 text-center">Status Absensi</th>
                <th class="py-3.5 px-4 text-center">Jam Masuk</th>
                <th class="py-3.5 px-4 text-center">Jam Pulang</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 font-medium text-slate-700 dark:text-slate-200">
            @forelse($attendances as $idx => $att)
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-900/40 transition-all">
                    <td class="py-3.5 px-4 text-center font-mono text-slate-400">{{ $idx + 1 + ($attendances->currentPage() - 1) * $attendances->perPage() }}</td>
                    <td class="py-3.5 px-4">
                        <div class="font-bold text-slate-900 dark:text-white text-sm">{{ $att->student->name ?? '-' }}</div>
                        <div class="text-[10px] font-mono text-slate-400">NISN: {{ $att->student->nisn ?? '-' }}</div>
                    </td>
                    <td class="py-3.5 px-4 text-center font-semibold">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 shadow-[inset_0_1px_0_#ffffff] dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">
                            Kelas {{ $att->student->classRoom->name ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        @php
                            $eff = $att->effective_status;
                            $badge = match($eff) {
                                'Hadir' => 'bg-emerald-50 text-emerald-800 border-emerald-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(16,185,129,0.15)] dark:bg-emerald-500/20 dark:text-emerald-300 dark:border-emerald-500/40',
                                'Terlambat' => 'bg-amber-50 text-amber-800 border-amber-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)] dark:bg-amber-500/20 dark:text-amber-300 dark:border-amber-500/40',
                                'Izin' => 'bg-sky-50 text-sky-800 border-sky-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(14,165,233,0.15)] dark:bg-sky-500/20 dark:text-sky-300 dark:border-sky-500/40',
                                'Sakit' => 'bg-amber-50 text-amber-900 border-amber-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(245,158,11,0.15)] dark:bg-amber-500/20 dark:text-amber-300 dark:border-amber-500/40',
                                default => 'bg-rose-50 text-rose-800 border-rose-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(244,63,94,0.15)] dark:bg-rose-500/20 dark:text-rose-300 dark:border-rose-500/40',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge }}">
                            {{ $eff }}
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800 dark:text-white">
                        {{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('H:i') : '-' }}
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        @if($att->time_out)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-900 border border-sky-300 shadow-[inset_0_1px_0_#ffffff,0_1px_2px_rgba(14,165,233,0.15)] dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800/50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1 text-sky-600 dark:text-sky-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                {{ \Carbon\Carbon::parse($att->time_out)->format('H:i') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200 shadow-[inset_0_1px_0_#ffffff] dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                                Menunggu Pulang
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-slate-400 dark:text-slate-500">
                        Belum ada siswa yang melakukan scan presensi hari ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($attendances->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
        {{ $attendances->links() }}
    </div>
@endif
