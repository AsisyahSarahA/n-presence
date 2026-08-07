<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Raport Semester - Kelas {{ $class->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { 
                margin: 1cm; 
                size: portrait;
            }
            html, body { 
                background: #ffffff !important; 
                background-color: #ffffff !important; 
                margin: 0 !important; 
                padding: 0 !important; 
                color: #000000 !important;
                width: 100% !important;
            }
            
            /* Sembunyikan elemen non-cetak */
            .no-print {
                display: none !important;
            }

            /* Hilangkan bayangan & border kotak pembungkus luar saat di-print */
            .print-paper-card {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
                background: transparent !important;
            }

            /* Pertahankan Garis Tabel Resmi dan Spasi Sel */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-top: 15px !important;
                margin-bottom: 20px !important;
            }

            table th, 
            table td {
                border: 1px solid #333333 !important;
                padding: 6px 8px !important;
                color: #000000 !important;
                font-size: 9pt !important;
                word-break: normal !important;
            }

            table th {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                font-weight: bold !important;
                text-transform: uppercase !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 p-8 font-sans">

    <!-- Action Bar -->
    <div class="no-print max-w-4xl mx-auto mb-6 bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between shadow-sm">
        <div>
            <h1 class="text-sm font-bold text-slate-800">Pratinjau Cetak Rekapitulasi Raport Semester</h1>
            <p class="text-xs text-slate-500">Kelas {{ $class->name }} | Semester {{ $semesterType == '1' ? '1 (Ganjil)' : '2 (Genap)' }} | TA {{ $academicYear->name ?? '-' }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.reports.daily', ['tab' => 'semester', 'semester_class_id' => $class->id, 'semester_type' => $semesterType, 'academic_year_id' => $academicYear->id]) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition-all border border-slate-200 flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
            <button onclick="window.print()" class="bg-[#1e3a5f] hover:bg-[#111e30] text-white px-5 py-2 rounded-xl text-xs font-bold transition-all shadow-md flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
                </svg>
                <span>Cetak Dokumen</span>
            </button>
        </div>
    </div>

    <!-- Official Paper Document Container -->
    <div class="print-paper-card max-w-4xl mx-auto bg-white p-8 border border-slate-300 shadow-md">
        
        <!-- Official Kop Surat -->
        <div class="flex items-center border-b-4 border-double border-slate-900 pb-3 mb-5">
            <div class="w-16 h-16 shrink-0 flex items-center justify-center mr-3">
                @if(!empty($appLogo) && file_exists(public_path('storage/' . $appLogo)))
                    <img src="{{ asset('storage/' . $appLogo) }}" alt="Logo Sekolah" class="w-14 h-14 object-contain">
                @elseif(!empty($appLogo) && file_exists(public_path($appLogo)))
                    <img src="{{ asset($appLogo) }}" alt="Logo Sekolah" class="w-14 h-14 object-contain">
                @else
                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center border border-slate-300">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1 text-center pr-16">
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-600">PEMERINTAH KABUPATEN / DINAS PENDIDIKAN</h2>
                <h1 class="text-xl font-extrabold uppercase text-slate-900 tracking-wide mt-0.5">{{ $schoolName }}</h1>
                <p class="text-[11px] text-slate-500 italic mt-0.5">Sistem Informasi Presensi Digital {{ $appName }}</p>
            </div>
        </div>

        <!-- Report Meta Header -->
        <div class="text-center mb-5">
            <h3 class="text-sm font-extrabold uppercase text-slate-900 tracking-wide underline decoration-2 underline-offset-4">REKAPITULASI PRESENSI UNTUK RAPORT SISWA</h3>
            <p class="text-xs text-slate-600 mt-1.5 font-medium">
                Semester: <strong class="text-slate-900">{{ $semesterType == '1' ? '1 (Ganjil)' : '2 (Genap)' }}</strong> &nbsp;|&nbsp; Tahun Ajaran: <strong class="text-slate-900">{{ $academicYear->name ?? '-' }}</strong> &nbsp;|&nbsp; Kelas: <strong class="text-slate-900">{{ $class->name }}</strong>
            </p>
        </div>

        <!-- Table Data Raport -->
        <table class="w-full text-left text-xs border-collapse border border-slate-400 mb-6">
            <thead>
                <tr class="bg-slate-100 text-slate-900 font-bold uppercase text-[10px] text-center border-b border-slate-400">
                    <th class="py-2 px-1 border border-slate-400 w-8">No</th>
                    <th class="py-2 px-2.5 border border-slate-400 text-left w-24">NISN</th>
                    <th class="py-2 px-2.5 border border-slate-400 text-left">Nama Siswa</th>
                    <th class="py-2 px-2 border border-slate-400 w-16">Sakit (S)</th>
                    <th class="py-2 px-2 border border-slate-400 w-16">Izin (I)</th>
                    <th class="py-2 px-2 border border-slate-400 w-20">Alpa (A)</th>
                    <th class="py-2 px-2.5 border border-slate-400 text-left w-48">Format Input Raport</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semesterData as $idx => $row)
                    <tr class="border-b border-slate-300">
                        <td class="py-1.5 px-1 border border-slate-300 text-center font-medium">{{ $idx + 1 }}</td>
                        <td class="py-1.5 px-2.5 border border-slate-300 font-mono text-[11px]">{{ $row['student']->nisn }}</td>
                        <td class="py-1.5 px-2.5 border border-slate-300 font-bold text-slate-900">{{ $row['student']->name }}</td>
                        <td class="py-1.5 px-2 border border-slate-300 text-center font-bold text-slate-900">{{ $row['sakit'] }} hr</td>
                        <td class="py-1.5 px-2 border border-slate-300 text-center font-bold text-slate-900">{{ $row['izin'] }} hr</td>
                        <td class="py-1.5 px-2 border border-slate-300 text-center font-bold text-slate-900">{{ $row['alpa'] }} hr</td>
                        <td class="py-1.5 px-2.5 border border-slate-300 font-mono text-[11px]">
                            S: {{ $row['sakit'] }} hr, I: {{ $row['izin'] }} hr, A: {{ $row['alpa'] }} hr
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-400">Tidak ada data rekapitulasi semester.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Signature Block -->
        <div class="mt-8 grid grid-cols-2 text-center text-xs text-slate-800">
            <div>
                <p class="font-medium">Mengetahui,</p>
                <p class="font-bold text-slate-900">Kepala Sekolah</p>
                <div class="h-16"></div>
                <p class="font-bold underline text-slate-900">( ________________________ )</p>
                <p class="text-[10px] text-slate-500 mt-0.5">NIP. ........................................</p>
            </div>
            <div>
                <p class="font-medium">Nangtang, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-slate-900">Wali Kelas {{ $class->name }}</p>
                <div class="h-16"></div>
                <p class="font-bold underline text-slate-900">( ________________________ )</p>
                <p class="text-[10px] text-slate-500 mt-0.5">NIP. ........................................</p>
            </div>
        </div>

    </div>

</body>
</html>
