<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Raport Semester - Kelas {{ $class->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; margin: 0; padding: 0; color: black; }
            .no-print { display: none !important; }
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
        <button onclick="window.print()" class="bg-primary hover:bg-slate-800 text-white px-5 py-2 rounded-xl text-xs font-bold transition-all shadow-md flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
            </svg>
            <span>Cetak Dokumen</span>
        </button>
    </div>

    <!-- Official Paper Document Container -->
    <div class="max-w-4xl mx-auto bg-white p-8 border border-slate-300 shadow-md">
        
        <!-- Official Kop Surat -->
        <div class="text-center border-b-4 border-double border-slate-900 pb-4 mb-6">
            <h2 class="text-xs font-bold uppercase tracking-widest text-slate-600">PEMERINTAH KABUPATEN / DINAS PENDIDIKAN</h2>
            <h1 class="text-xl font-extrabold uppercase text-slate-900 tracking-wide mt-0.5">{{ $schoolName }}</h1>
            <p class="text-[11px] text-slate-500 italic mt-0.5">Sistem Informasi Presensi Digital {{ $appName }}</p>
        </div>

        <!-- Report Meta Header -->
        <div class="text-center mb-6">
            <h3 class="text-base font-bold uppercase text-slate-800 underline tracking-wide">REKAPITULASI PRESENSI UNTUK RAPORT SISWA</h3>
            <p class="text-xs text-slate-600 mt-1 font-medium">
                Semester: <strong>{{ $semesterType == '1' ? '1 (Ganjil)' : '2 (Genap)' }}</strong> | Tahun Ajaran: <strong>{{ $academicYear->name ?? '-' }}</strong> | Kelas: <strong>{{ $class->name }}</strong>
            </p>
        </div>

        <!-- Table Data Raport -->
        <table class="w-full text-left text-xs border-collapse border border-slate-400 mb-8">
            <thead>
                <tr class="bg-slate-100 text-slate-800 font-bold uppercase text-[10px] text-center border-b border-slate-400">
                    <th class="py-2.5 px-2 border border-slate-400 w-10">No</th>
                    <th class="py-2.5 px-3 border border-slate-400 text-left">NISN</th>
                    <th class="py-2.5 px-3 border border-slate-400 text-left">Nama Siswa</th>
                    <th class="py-2.5 px-2 border border-slate-400">Sakit (S)</th>
                    <th class="py-2.5 px-2 border border-slate-400">Izin (I)</th>
                    <th class="py-2.5 px-2 border border-slate-400">Tanpa Keterangan / Alpa (A)</th>
                    <th class="py-2.5 px-3 border border-slate-400 text-left">Format Input Raport</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semesterData as $idx => $row)
                    <tr class="border-b border-slate-300">
                        <td class="py-2 px-2 border border-slate-300 text-center">{{ $idx + 1 }}</td>
                        <td class="py-2 px-3 border border-slate-300 font-mono">{{ $row['student']->nisn }}</td>
                        <td class="py-2 px-3 border border-slate-300 font-bold">{{ $row['student']->name }}</td>
                        <td class="py-2 px-2 border border-slate-300 text-center font-bold">{{ $row['sakit'] }} hari</td>
                        <td class="py-2 px-2 border border-slate-300 text-center font-bold">{{ $row['izin'] }} hari</td>
                        <td class="py-2 px-2 border border-slate-300 text-center font-bold">{{ $row['alpa'] }} hari</td>
                        <td class="py-2 px-3 border border-slate-300 font-mono text-[11px]">
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
        <div class="mt-12 grid grid-cols-2 text-center text-xs text-slate-800">
            <div>
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala Sekolah</p>
                <div class="h-20"></div>
                <p class="font-bold underline">( ________________________ )</p>
                <p class="text-[10px] text-slate-500">NIP. ........................................</p>
            </div>
            <div>
                <p>Nangtang, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Wali Kelas {{ $class->name }}</p>
                <div class="h-20"></div>
                <p class="font-bold underline">( ________________________ )</p>
                <p class="text-[10px] text-slate-500">NIP. ........................................</p>
            </div>
        </div>

    </div>

</body>
</html>
