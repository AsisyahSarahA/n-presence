<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Absensi Portrait - Kelas {{ $class->name }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 6mm;
            }
            body {
                background: white !important;
                color: black !important;
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
            }
        }
        
        .id-card-portrait {
            width: 6.0cm;
            height: 10.2cm;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
            border: 1px solid #334155;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    </style>
</head>
<body class="bg-slate-900 min-h-screen p-6 font-sans text-slate-100">

    <!-- Action Bar (Hidden during Print) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-slate-800 p-4 rounded-2xl border border-slate-700 flex items-center justify-between shadow-xl">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.qr-cards.index') }}" class="text-slate-400 hover:text-white hover:bg-slate-700 p-2 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-white">Pratinjau Cetak Kartu QR Siswa (Format Portrait Presisi)</h1>
                <p class="text-xs text-slate-400">
                    {{ $students->count() === 1 ? 'Siswa: ' . $students->first()->name : 'Kelas: ' . $class->name . ' (' . $students->count() . ' siswa)' }}
                    — Format Portrait Tegak, Ukuran Pas Anti-Terpotong
                </p>
            </div>
        </div>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-lg flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
            </svg>
            <span>Cetak Kartu Sekarang</span>
        </button>
    </div>

    <!-- Printable Cards Container Grid -->
    <div class="max-w-5xl mx-auto flex flex-wrap justify-center gap-5 print:gap-3">
        @forelse($students as $student)
            <div class="card-wrapper">
                <div class="id-card-portrait rounded-2xl p-3 flex flex-col justify-between shadow-2xl relative overflow-hidden text-center border-2 border-slate-700">
                    
                    <!-- Background Glow Elements -->
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/10 rounded-full blur-xl pointer-events-none"></div>
                    <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>

                    <!-- CARD HEADER -->
                    <div class="border-b border-slate-700/80 pb-1.5 z-10">
                        <div class="flex items-center justify-center space-x-1.5">
                            @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                                <img src="{{ asset($appLogo) }}" alt="Logo" class="h-5 w-auto object-contain">
                            @else
                                <div class="w-4.5 h-4.5 rounded bg-blue-500 text-white font-bold text-[9px] flex items-center justify-center">
                                    {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                                </div>
                            @endif
                            <h2 class="text-[8.5px] font-extrabold uppercase text-slate-100 tracking-wider truncate max-w-[150px] leading-tight">
                                {{ $schoolName }}
                            </h2>
                        </div>
                        <p class="text-[7px] font-semibold text-slate-400 tracking-widest uppercase mt-0.5">KARTU ABSENSI DIGITAL SISWA</p>
                    </div>

                    <!-- STUDENT PROFILE SECTION -->
                    <div class="z-10 my-1 flex flex-col items-center">
                        @if($student->photo_path)
                            <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto" class="w-12 h-12 object-cover rounded-full border-2 border-blue-400 shadow-md">
                        @else
                            <div class="w-11 h-11 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-full border-2 border-white/20 shadow-md flex items-center justify-center text-white font-black text-sm my-0.5">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                        @endif

                        <h3 class="text-[11px] font-extrabold text-white mt-1 leading-tight tracking-wide uppercase truncate max-w-[170px]">
                            {{ $student->name }}
                        </h3>
                        <p class="text-[8px] font-mono text-slate-300 mt-0.5">NISN: {{ $student->nisn }}</p>
                        <div class="mt-1 inline-block px-2.5 py-0.5 bg-blue-500/20 text-blue-300 border border-blue-400/30 rounded-full text-[8px] font-extrabold">
                            Kelas {{ $class->name }}
                        </div>
                    </div>

                    <!-- PROMINENT LARGE QR CODE -->
                    <div class="z-10 my-0.5 flex justify-center">
                        <div class="p-1.5 bg-white rounded-xl shadow-md border border-white">
                            {!! QrCode::size(110)->generate($student->nisn) !!}
                        </div>
                    </div>

                    <!-- CARD FOOTER (Guaranteed margin from bottom) -->
                    <div class="border-t border-slate-700/80 pt-1 z-10 flex items-center justify-between text-[8px] font-bold text-slate-300">
                        <span>TA {{ $class->academicYear->name ?? '-' }}</span>
                        <span class="text-blue-400 font-extrabold tracking-wider">{{ $appName }}</span>
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
