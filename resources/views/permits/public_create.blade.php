<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Izin / Sakit Siswa - {{ $appName ?? 'N-Presence' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a5f',
                        'primary-dark': '#182e4b',
                        'primary-deep': '#0f1d30',
                        secondary: '#3b82f6',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .skeuo-card {
            background: linear-gradient(180deg, #ffffff 0%, #fafbfd 100%);
            border: 1px solid #e2e8f0;
            border-top: 1px solid #ffffff;
            box-shadow: 
                inset 0 1px 0 #ffffff,
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 14px 30px -4px rgba(15, 23, 42, 0.12);
        }
        .skeuo-input {
            height: 2.75rem;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.05),
                0 1px 0 #ffffff;
            transition: all 0.15s ease-in-out;
        }
        .skeuo-input:focus {
            background: #ffffff;
            border-color: #1e3a5f;
            box-shadow: 
                inset 0 1px 2px rgba(0, 0, 0, 0.04),
                0 0 0 3px rgba(30, 58, 95, 0.15);
            outline: none;
        }
        .skeuo-btn-primary {
            height: 2.75rem;
            background: linear-gradient(180deg, #254670 0%, #1e3a5f 55%, #182e4b 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.35);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.15);
            border-bottom: 3px solid #0f1d30;
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.25),
                0 3px 6px rgba(15, 23, 42, 0.25);
            transition: all 0.1s ease-in-out;
        }
        .skeuo-btn-primary:hover {
            filter: brightness(1.05);
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                0 4px 8px rgba(15, 23, 42, 0.3);
        }
        .skeuo-btn-primary:active {
            transform: translateY(2px);
            border-bottom-width: 1px;
            box-shadow: 
                inset 0 2px 4px rgba(0, 0, 0, 0.4),
                0 1px 2px rgba(15, 23, 42, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200 min-h-screen py-10 px-4 font-sans flex items-center justify-center text-slate-800">

    <div class="w-full max-w-xl skeuo-card rounded-3xl overflow-hidden my-auto relative">
        <!-- Header Slab -->
        <div class="bg-gradient-to-b from-[#244570] via-primary to-[#182e4b] text-white p-7 text-center relative overflow-hidden border-b-2 border-b-[#0f1d30] shadow-[inset_0_1px_0_rgba(255,255,255,0.25)]">
            <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
            @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                <div class="inline-block p-2.5 bg-white/95 rounded-2xl border border-white/40 shadow-[0_4px_12px_rgba(0,0,0,0.2)] mb-3 transition-transform hover:scale-105">
                    <img src="{{ asset($appLogo) }}" alt="Logo" class="h-14 w-auto max-w-[140px] object-contain drop-shadow-sm">
                </div>
            @else
                <div class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center mx-auto mb-3 font-bold text-2xl border-t border-t-white/30 border-b border-b-black/40 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                    {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                </div>
            @endif
            <h1 class="text-xl font-extrabold tracking-tight">{{ $appName ?? 'N-Presence' }}</h1>
            <p class="text-xs text-slate-200 mt-1 font-medium">{{ $schoolName ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}</p>
            <div class="mt-3.5 inline-flex items-center px-4 py-1.5 bg-white/10 rounded-full text-xs font-semibold text-slate-100 border border-white/15 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 mr-1.5 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Form Pengajuan Izin / Sakit Siswa
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 border-l-4 border-l-emerald-500 text-emerald-900 rounded-xl text-xs font-medium space-y-1.5 shadow-[inset_0_1px_0_#ffffff]">
                    <div class="flex items-center font-bold text-sm text-emerald-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <p class="text-emerald-700 pl-6">Pengajuan Anda telah tercatat dan sedang menunggu verifikasi dari pihak sekolah.</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 border-l-4 border-l-rose-500 text-rose-800 rounded-xl text-xs font-semibold shadow-[inset_0_1px_0_#ffffff]">
                    <div class="font-bold mb-1">Periksa kembali data formulir:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('public.permits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Pilih Siswa -->
                <div>
                    <label for="student_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Siswa / Anak</label>
                    <div class="relative">
                        <select name="student_id" id="student_id" required
                            class="w-full px-4 py-3 rounded-xl text-sm font-medium text-slate-900 skeuo-input cursor-pointer">
                            <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>-- Cari / Pilih Nama Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} (Kelas {{ $student->classRoom->name ?? '-' }}) — NISN: {{ $student->nisn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Informasi Orang Tua / Wali -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="parent_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Orang Tua / Wali</label>
                        <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Bpk. Ahmad"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input">
                    </div>
                    <div>
                        <label for="parent_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp / HP</label>
                        <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone') }}" required placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input">
                    </div>
                </div>

                <!-- Jenis Ketidakhadiran -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Alasan Ketidakhadiran</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center cursor-pointer select-none">
                            <input type="radio" name="status_type" value="Izin" {{ old('status_type', 'Izin') == 'Izin' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full text-center py-3 px-4 rounded-xl text-sm font-bold border border-slate-200 bg-slate-50 text-slate-600 shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.04)] transition-all peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-[inset_0_2px_4px_rgba(0,0,0,0.35)] flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <span>Izin</span>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-center cursor-pointer select-none">
                            <input type="radio" name="status_type" value="Sakit" {{ old('status_type') == 'Sakit' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full text-center py-3 px-4 rounded-xl text-sm font-bold border border-slate-200 bg-slate-50 text-slate-600 shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.04)] transition-all peer-checked:border-amber-600 peer-checked:bg-amber-600 peer-checked:text-white peer-checked:shadow-[inset_0_2px_4px_rgba(0,0,0,0.35)] flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                <span>Sakit</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', now()->toDateString()) }}" required
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', now()->toDateString()) }}" required
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input">
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alasan / Keterangan Lengkap</label>
                    <textarea name="notes" id="notes" rows="3" required placeholder="Jelaskan alasan izin / sakit..."
                        class="w-full px-4 py-2.5 rounded-xl text-sm font-medium text-slate-900 skeuo-input resize-none">{{ old('notes') }}</textarea>
                </div>

                <!-- Upload Bukti Surat -->
                <div>
                    <label for="attachment" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Bukti Surat (Dokter / Surat Izin)</label>
                    <input type="file" name="attachment" id="attachment" accept="image/jpeg,image/png,image/webp,application/pdf"
                        class="w-full px-4 py-2.5 rounded-xl text-xs text-slate-600 skeuo-input file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-t file:border-t-white/20 file:border-b-2 file:border-b-slate-900 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:brightness-105 cursor-pointer">
                    <p class="text-[11px] text-slate-500 mt-1.5 font-medium">Format: JPG, PNG, WEBP, PDF (Maksimal 2 MB). *Opsional</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-200">
                    <button type="submit" class="w-full skeuo-btn-primary text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center space-x-2 text-sm tracking-wide cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        <span>Kirim Pengajuan Izin</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Deck -->
        <div class="px-8 py-4 bg-slate-50/90 border-t border-slate-200/80 shadow-[inset_0_1px_0_#ffffff] text-center">
            <span class="text-[11px] text-slate-500 font-medium">
                {{ $appFooter ?? '© 2026 KKN Kelompok 02 Cigalontang. All rights reserved.' }}
            </span>
        </div>
    </div>

</body>
</html>
