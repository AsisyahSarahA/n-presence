<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 1. Hitung Statistik Hari Ini
        $totalStudents = Student::where('is_active', true)->count();
        $totalHadir = Attendance::where('date', $today)->where('status', 'Hadir')->count();
        $totalTerlambat = Attendance::where('date', $today)->where('status', 'Terlambat')->count();
        $totalAlpa = Attendance::where('date', $today)->where('status', 'Alpa')->count();
        $totalIzinSakit = Attendance::where('date', $today)->whereIn('status', ['Izin', 'Sakit'])->count();

        // 2. Data Tabel Siswa Terlambat Hari Ini
        $lateStudents = Attendance::with('student.classRoom')
            ->where('date', $today)
            ->where('status', 'Terlambat')
            ->orderBy('time_in', 'asc')
            ->paginate(7);

        // 3. Data Chart 7 Hari Terakhir (Tren Kehadiran)
        $trends = Attendance::select('date', 
                DB::raw("SUM(case when status = 'Hadir' then 1 else 0 end) as hadir"),
                DB::raw("SUM(case when status = 'Terlambat' then 1 else 0 end) as terlambat")
            )
            ->where('date', '>=', Carbon::today()->subDays(6)->toDateString())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = [];
        $chartHadir = [];
        $chartTerlambat = [];

        // Buat data default 7 hari jika kosong
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $label = Carbon::today()->subDays($i)->translatedFormat('d M');
            $chartLabels[] = $label;

            $trend = $trends->firstWhere('date', $date);
            $chartHadir[] = $trend ? (int) $trend->hadir : 0;
            $chartTerlambat[] = $trend ? (int) $trend->terlambat : 0;
        }

        return view('admin.dashboard', compact(
            'totalStudents', 'totalHadir', 'totalTerlambat', 'totalAlpa', 'totalIzinSakit',
            'lateStudents', 'chartLabels', 'chartHadir', 'chartTerlambat'
        ));
    }

    public function finalize(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // Ambil semua siswa aktif
        $activeStudents = Student::where('is_active', true)->get();

        $countGenerated = 0;

        DB::transaction(function () use ($activeStudents, $today, &$countGenerated) {
            foreach ($activeStudents as $student) {
                // Cek apakah siswa sudah memiliki data absensi hari ini
                $exists = Attendance::where('student_id', $student->id)
                    ->where('date', $today)
                    ->exists();

                // Jika belum scan atau belum diinput, tandai sebagai Alpa
                if (!$exists) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'date' => $today,
                        'status' => 'Alpa',
                        'time_in' => null,
                        'time_out' => null,
                        'late_duration_minutes' => 0,
                        'notes' => 'Tidak hadir tanpa keterangan (Finalisasi Sistem)'
                    ]);
                    $countGenerated++;
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => "Absensi hari ini berhasil ditutup. {$countGenerated} siswa ditandai Alpa."
        ]);
    }
}
