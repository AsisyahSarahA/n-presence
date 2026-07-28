<table>
    <thead>
        <tr>
            <th colspan="6" style="font-weight: bold; text-align: center; font-size: 14px;">REKAP KEHADIRAN HARIAN SISWA</th>
        </tr>
        <tr>
            <th colspan="6" style="font-weight: bold; text-align: center; font-size: 12px;">{{ strtoupper($schoolName) }}</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">Kelas: {{ $classRoom->name }} (Wali Kelas: {{ $classRoom->homeroom_teacher ?? '-' }})</th>
        </tr>
        <tr></tr>
        <tr style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #000000;">
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid #000000; font-weight: bold;">NISN</th>
            <th style="border: 1px solid #000000; font-weight: bold;">Nama Siswa</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">Jam Masuk</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">Jam Pulang</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $index => $attendance)
            <tr>
                <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000; font-family: monospace;">'{{ $attendance->student->nisn }}</td>
                <td style="border: 1px solid #000000;">{{ $attendance->student->name }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $attendance->time_in ?? '-' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $attendance->time_out ?? '-' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $attendance->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
