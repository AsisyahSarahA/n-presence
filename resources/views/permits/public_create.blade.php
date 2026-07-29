<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Izin / Sakit Siswa - {{ $appName ?? 'N-Presence' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a5f',
                        secondary: '#3b82f6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 min-h-screen py-8 px-4 font-sans flex items-center justify-center">

    <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden my-auto">
        <!-- Header -->
        <div class="bg-primary text-white p-6 text-center relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
            @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                <img src="{{ asset($appLogo) }}" alt="Logo" class="h-16 w-auto max-w-[140px] object-contain mx-auto mb-3 drop-shadow-md">
            @else
                <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center mx-auto mb-3 font-bold text-xl border border-white/20">
                    {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                </div>
            @endif
            <h1 class="text-xl font-bold tracking-wide">{{ $appName ?? 'N-Presence' }}</h1>
            <p class="text-xs text-slate-300 mt-1 font-medium">{{ $schoolName ?? 'SMP Negeri Nangtang' }}</p>
            <div class="mt-4 inline-block px-4 py-1.5 bg-white/10 rounded-full text-xs font-medium text-slate-200 border border-white/10">
                Form Pengajuan Izin / Sakit Siswa Mandiri
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-2xl text-sm space-y-2">
                    <div class="flex items-center font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <p class="text-xs text-emerald-700">Pengajuan Anda telah tercatat dan sedang menunggu verifikasi dari pihak sekolah.</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-2xl text-sm">
                    <div class="font-semibold mb-1">Terjadi kesalahan pada input:</div>
                    <ul class="list-disc list-inside space-y-1 text-xs">
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
                    <label for="student_id" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pilih Siswa / Anak</label>
                    <select name="student_id" id="student_id" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 font-medium">
                        <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>-- Cari / Pilih Nama Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} (Kelas {{ $student->classRoom->name ?? '-' }}) — NISN: {{ $student->nisn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Informasi Orang Tua / Wali -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="parent_name" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Orang Tua / Wali</label>
                        <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Bpk. Ahmad"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                    </div>
                    <div>
                        <label for="parent_phone" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">No. WhatsApp / HP</label>
                        <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone') }}" required placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                    </div>
                </div>

                <!-- Jenis Ketidakhadiran -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jenis Alasan Ketidakhadiran</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center cursor-pointer">
                            <input type="radio" name="status_type" value="Izin" {{ old('status_type') == 'Izin' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full text-center py-3 px-4 rounded-xl text-sm font-semibold border-2 border-slate-200 bg-slate-50 text-slate-600 transition-all peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary hover:bg-slate-100">
                                ✉️ Izin
                            </div>
                        </label>
                        <label class="relative flex items-center justify-center cursor-pointer">
                            <input type="radio" name="status_type" value="Sakit" {{ old('status_type') == 'Sakit' ? 'checked' : '' }} required class="sr-only peer">
                            <div class="w-full text-center py-3 px-4 rounded-xl text-sm font-semibold border-2 border-slate-200 bg-slate-50 text-slate-600 transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-800 hover:bg-slate-100">
                                🤒 Sakit
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', now()->toDateString()) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', now()->toDateString()) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800">
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Alasan / Keterangan Lengkap</label>
                    <textarea name="notes" id="notes" rows="3" required placeholder="Jelaskan alasan izin / sakit..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-slate-800 resize-none">{{ old('notes') }}</textarea>
                </div>

                <!-- Upload Bukti Surat -->
                <div>
                    <label for="attachment" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Upload Bukti Surat (Dokter / Surat Izin)</label>
                    <input type="file" name="attachment" id="attachment" accept="image/jpeg,image/png,image/webp,application/pdf"
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-slate-800 transition-all cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP, PDF (Maksimal 2 MB). *Opsional</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-primary hover:bg-slate-800 text-white font-semibold py-3.5 rounded-xl transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 flex items-center justify-center space-x-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        <span>Kirim Pengajuan Izin</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-center">
            <span class="text-xs text-slate-400">{{ $appFooter ?? '© 2026 KKN Kelompok 02 Nangtang. All rights reserved.' }}</span>
        </div>
    </div>

</body>
</html>
