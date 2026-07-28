<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran Harian</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #1e3a5f;
            font-weight: 700;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .meta-table td {
            padding: 3px 0;
        }
        .meta-label {
            font-weight: bold;
            color: #475569;
            width: 15%;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .report-table th {
            background-color: #1e3a5f;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            border: 1px solid #1e3a5f;
        }
        .report-table td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
        }
        .report-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .badge-hadir {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-terlambat {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-alpa {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-izin {
            background-color: #e0f2fe;
            color: #075985;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>REKAP KEHADIRAN HARIAN SISWA</h1>
        <h2>{{ $schoolName }}</h2>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</td>
            <td class="meta-label">Kelas</td>
            <td>: {{ $classRoom->name }}</td>
        </tr>
        <tr>
            <td class="meta-label">Wali Kelas</td>
            <td>: {{ $classRoom->homeroom_teacher ?? '-' }}</td>
            <td class="meta-label">Tahun Ajaran</td>
            <td>: {{ $classRoom->academicYear->name }}</td>
        </tr>
    </table>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">NISN</th>
                <th style="width: 40%;">Nama Siswa</th>
                <th style="width: 13%;" class="text-center">Jam Masuk</th>
                <th style="width: 13%;" class="text-center">Jam Pulang</th>
                <th style="width: 14%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $attendance)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $attendance->student->nisn }}</td>
                    <td><strong>{{ $attendance->student->name }}</strong></td>
                    <td class="text-center">{{ $attendance->time_in ?? '-' }}</td>
                    <td class="text-center">{{ $attendance->time_out ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ strtolower($attendance->status) }}">
                            {{ $attendance->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #94a3b8;">Belum ada data absensi untuk parameter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
