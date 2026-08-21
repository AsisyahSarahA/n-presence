<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Absensi Siswa - {{ $class->name ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 5mm;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .card-wrapper {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin: 2mm !important;
            }
        }
        
        .id-card-portrait {
            width: 5.85cm;
            height: 9.85cm;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
            background: #ffffff;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Subtle Security Guilloche Pattern */
        .security-pattern {
            background-image: radial-gradient(rgba(14, 116, 144, 0.06) 1px, transparent 0);
            background-size: 8px 8px;
        }
    </style>
</head>
<body class="bg-slate-900 min-h-screen p-6 font-sans text-slate-100">

    <!-- Action Bar (Hidden during Print) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-slate-800 p-4 rounded-2xl border border-slate-700 flex flex-wrap items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.qr-cards.index') }}" class="text-slate-400 hover:text-white hover:bg-slate-700 p-2 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-white flex items-center gap-2">
                    <span>Pratinjau Cetak Kartu Absensi Siswa</span>
                    <span class="px-2 py-0.5 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-full text-[10px] font-bold">Format Formal & Presisi</span>
                </h1>
                <p class="text-xs text-slate-400">
                    {{ $students->count() === 1 ? 'Siswa: ' . $students->first()->name : 'Kelas: ' . $class->name . ' (' . $students->count() . ' siswa)' }}
                    — Siap Cetak A4 (3 Kolom per Halaman)
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-[11px] text-slate-400 hidden sm:block">
                <span>Tips: Gunakan kertas <strong>Glory Photo Paper / PVC</strong></span>
            </div>
            <button onclick="window.print()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-lg flex items-center space-x-2 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                </svg>
                <span>Cetak Kartu Sekarang</span>
            </button>
        </div>
    </div>

    <!-- Printable Cards Container Grid -->
    <div class="max-w-5xl mx-auto flex flex-wrap justify-center gap-6 print:gap-3">
        @forelse($students as $student)
            <div class="card-wrapper p-0.5 rounded-2xl border border-dashed border-slate-600 print:border-slate-300">
                <div class="id-card-portrait rounded-2xl flex flex-col justify-between shadow-xl relative overflow-hidden border border-slate-300/80 bg-white text-slate-800">
                    
                    <!-- TOP HEADER: Navy & Gold Official Band -->
                    <div class="relative bg-gradient-to-r from-[#0b1e36] via-[#122e54] to-[#0b1e36] text-white pt-2.5 pb-2 px-2 text-center border-b-2 border-amber-400">
                        <!-- Top Accent Light -->
                        <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-transparent via-amber-300 to-transparent"></div>
                        
                        <div class="flex items-center justify-center space-x-1.5 mb-0.5">
                            @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                                <img src="{{ asset($appLogo) }}" alt="Logo" class="h-4.5 w-auto object-contain drop-shadow-sm">
                            @else
                                <div class="w-4 h-4 rounded-md bg-gradient-to-br from-amber-400 to-amber-600 text-slate-900 font-extrabold text-[8.5px] flex items-center justify-center shadow-sm">
                                    {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                                </div>
                            @endif
                            <h2 class="text-[8px] font-black uppercase text-white tracking-wider truncate max-w-[155px] leading-tight drop-shadow-sm">
                                {{ $schoolName ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}
                            </h2>
                        </div>
                        
                        <div class="flex items-center justify-center space-x-1.5 mt-0.5">
                            <span class="h-[1px] w-4 bg-amber-400/60"></span>
                            <p class="text-[6.5px] font-bold text-amber-300 tracking-[0.12em] uppercase">KARTU ABSENSI DIGITAL SISWA</p>
                            <span class="h-[1px] w-4 bg-amber-400/60"></span>
                        </div>
                    </div>

                    <!-- CARD BODY: Security Pattern Background -->
                    <div class="security-pattern px-2.5 py-1.5 flex-1 flex flex-col items-center justify-between relative">
                        
                        <!-- Watermark Security Emblem -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-[0.035] pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-36 h-36 text-slate-900">
                                <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.137-.089l4.003-5.604Z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- STUDENT PROFILE -->
                        <div class="z-10 flex flex-col items-center text-center w-full mt-0.5">
                            <!-- Photo with Double Ring Gold/Navy Border -->
                            <div class="relative mb-1">
                                <div class="w-13 h-13 p-0.5 rounded-full bg-gradient-to-tr from-amber-500 via-blue-600 to-amber-400 shadow-md">
                                    @if($student->photo_path)
                                        <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto" class="w-12 h-12 object-cover rounded-full bg-white border border-white">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#0f2744] to-[#1e3a5f] border border-white flex items-center justify-center text-white font-black text-sm shadow-inner">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Student Name -->
                            <h3 class="text-[10px] font-extrabold text-slate-900 leading-tight uppercase tracking-tight truncate w-full px-1">
                                {{ $student->name }}
                            </h3>

                            <!-- Student Metadata Pills -->
                            <div class="flex items-center justify-center gap-1 mt-1">
                                <span class="px-1.5 py-0.5 bg-slate-100 border border-slate-300/80 rounded-md text-[7px] font-mono-code font-bold text-slate-700">
                                    NISN: {{ $student->nisn }}
                                </span>
                                <span class="px-1.5 py-0.5 bg-blue-50 border border-blue-200 rounded-md text-[7px] font-bold text-blue-800">
                                    Kelas {{ $class->name }}
                                </span>
                            </div>
                        </div>

                        <!-- QR CODE WITH SCANNER BRACKETS -->
                        <div class="z-10 my-1 relative">
                            <!-- Corner Scanner Guide Brackets -->
                            <div class="p-1.5 bg-white rounded-xl shadow-md border border-slate-200/90 relative">
                                <span class="absolute top-0.5 left-0.5 w-2 h-2 border-t-2 border-l-2 border-amber-500 rounded-tl-sm pointer-events-none"></span>
                                <span class="absolute top-0.5 right-0.5 w-2 h-2 border-t-2 border-r-2 border-amber-500 rounded-tr-sm pointer-events-none"></span>
                                <span class="absolute bottom-0.5 left-0.5 w-2 h-2 border-b-2 border-l-2 border-amber-500 rounded-bl-sm pointer-events-none"></span>
                                <span class="absolute bottom-0.5 right-0.5 w-2 h-2 border-b-2 border-r-2 border-amber-500 rounded-br-sm pointer-events-none"></span>

                                {!! QrCode::size(105)->generate($student->nisn) !!}
                            </div>
                            <p class="text-[6px] font-semibold text-slate-400 text-center mt-0.5 tracking-wider uppercase">Scan untuk Presensi</p>
                        </div>

                    </div>

                    <!-- CARD FOOTER: Formal Navy Bar with Security Holographic Strip -->
                    <div class="bg-gradient-to-r from-[#0b1e36] via-[#122e54] to-[#0b1e36] text-white px-2.5 py-1.5 border-t-2 border-amber-400 flex items-center justify-between text-[7px] font-semibold">
                        <div class="flex items-center space-x-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span class="text-slate-300 font-mono-code">TA {{ $class->academicYear->name ?? '2026/2027' }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="text-amber-300 font-extrabold tracking-wider">{{ $appName ?? 'N-Presence' }}</span>
                            <span class="text-[6px] text-slate-400">ID</span>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="no-print text-center py-12 text-slate-400 bg-slate-800 rounded-2xl w-full border border-slate-700">
                Tidak ada data siswa aktif di kelas ini untuk dicetak.
            </div>
        @endforelse
    </div>

</body>
</html>
