<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Absensi - Kelas {{ $class->name }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                background: white;
                color: black;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .card-page {
                page-break-after: always;
            }
        }
        
        .id-card {
            width: 10cm;
            height: 7cm;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            background: linear-gradient(135deg, #f0f7ff 0%, #fffdf5 100%);
            border: 1px solid rgba(30, 58, 95, 0.12);
        }
    </style>
</head>
<body class="bg-slate-100 p-6">

    <!-- Action Bar (Hidden during Print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between shadow-sm">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.qr-cards.index') }}" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-base font-bold text-slate-800">{{ $students->count() === 1 ? 'Cetak Kartu Individu' : 'Cetak Kartu Absensi' }}</h1>
                <p class="text-xs text-slate-500">{{ $students->count() === 1 ? 'Kelas: ' . $class->name : 'Kelas: ' . $class->name . ' | Jumlah: ' . $students->count() . ' siswa' }}</p>
            </div>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all shadow-md flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z" />
            </svg>
            <span>Cetak Sekarang</span>
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">
        @forelse($students as $student)
            <div class="id-card rounded-3xl p-4 flex flex-col justify-between shadow-lg relative overflow-hidden">
                <!-- Background Pastel Accents -->
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-amber-200/20 rounded-full blur-xl"></div>
                <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-blue-300/20 rounded-full blur-xl"></div>

                <!-- Top Header -->
                <div class="flex items-center space-x-2.5 border-b border-indigo-900/10 pb-2 z-10">
                    <div class="w-7 h-7 rounded-lg bg-indigo-900/10 flex items-center justify-center text-indigo-900 font-bold text-xs uppercase">
                        N
                    </div>
                    <div>
                        <h2 class="text-[10px] font-extrabold text-indigo-955 tracking-wider uppercase leading-none">{{ $schoolName }}</h2>
                        <span class="text-[8px] font-medium text-slate-500">Tahun Ajaran: {{ $class->academicYear->name }}</span>
                    </div>
                </div>

                <!-- Middle Content -->
                <div class="flex items-center justify-between my-2 z-10">
                    <!-- Photo & Bio -->
                    <div class="flex items-center space-x-3">
                        @if($student->photo_path)
                            <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto" class="w-16 h-16 object-cover rounded-full border border-white shadow-md">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-tr from-indigo-100 to-indigo-50 rounded-full border border-white shadow-md flex items-center justify-center text-indigo-400 font-bold text-lg">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                        @endif

                        <div class="space-y-0.5">
                            <h3 class="text-xs font-bold text-slate-800 leading-snug w-32 truncate">{{ $student->name }}</h3>
                            <p class="text-[9px] font-mono text-slate-500">NISN: {{ $student->nisn }}</p>
                            <span class="inline-block text-[8px] font-extrabold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">
                                Kelas {{ $class->name }}
                            </span>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="p-1 bg-white border border-slate-100 rounded-xl shadow-sm">
                        {!! QrCode::size(70)->generate($student->nisn) !!}
                    </div>
                </div>

                <!-- Footer Accents -->
                <div class="flex items-center justify-between border-t border-indigo-900/10 pt-1.5 text-[8px] text-slate-400 font-semibold z-10">
                    <span>KARTU ABSENSI DIGITAL</span>
                    <span class="text-indigo-950 font-bold">N-PRESENCE</span>
                </div>
            </div>
        @empty
            <div class="no-print col-span-2 text-center py-12 text-slate-400 bg-white rounded-2xl w-full border border-slate-200">
                Tidak ada data siswa aktif di kelas ini untuk dicetak.
            </div>
        @endforelse
    </div>

</body>
</html>
