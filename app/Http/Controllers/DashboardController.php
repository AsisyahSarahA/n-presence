<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 1. Hitung Ringkasan Absensi Hari Ini
        $totalStudents = Student::where('is_active', true)->count();
        $totalHadir = Attendance::where('date', $today)->where('status', 'Hadir')->count();
        $totalTerlambat = Attendance::where('date', $today)->where('status', 'Terlambat')->count();
        $totalAlpa = Attendance::where('date', $today)->where('status', 'Alpa')->count();
        $totalIzinSakit = Attendance::where('date', $today)->whereIn('status', ['Izin', 'Sakit'])->count();
        $totalSudahPulang = Attendance::where('date', $today)->whereNotNull('time_out')->count();

        $totalScanned = $totalHadir + $totalTerlambat + $totalIzinSakit + $totalAlpa;
        $attendancePercentage = $totalStudents > 0 ? round((($totalHadir + $totalTerlambat) / $totalStudents) * 100, 1) : 0;

        // 2. Aktivitas Presensi Terbaru Hari Ini (Live Stream)
        $recentScans = Attendance::with(['student.classRoom'])
            ->where('date', $today)
            ->whereNotNull('time_in')
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        // 3. Rekap Per Kelas Hari Ini
        $classSummaries = ClassRoom::withCount(['students' => function($q) {
                $q->where('is_active', true);
            }])
            ->get()
            ->map(function($class) use ($today) {
                $studentIds = $class->students()->pluck('id');

                $hadir = Attendance::whereIn('student_id', $studentIds)->where('date', $today)->where('status', 'Hadir')->count();
                $terlambat = Attendance::whereIn('student_id', $studentIds)->where('date', $today)->where('status', 'Terlambat')->count();
                $izinSakit = Attendance::whereIn('student_id', $studentIds)->where('date', $today)->whereIn('status', ['Izin', 'Sakit'])->count();
                $alpa = Attendance::whereIn('student_id', $studentIds)->where('date', $today)->where('status', 'Alpa')->count();

                return [
                    'id' => $class->id,
                    'name' => $class->name,
                    'total' => $class->students_count,
                    'hadir' => $hadir + $terlambat,
                    'terlambat' => $terlambat,
                    'izin' => $izinSakit,
                    'alpa' => $alpa,
                    'percentage' => $class->students_count > 0 ? round((($hadir + $terlambat) / $class->students_count) * 100) : 0
                ];
            });

        // 4. Data Tabel Siswa Terlambat Hari Ini
        $lateStudents = Attendance::with('student.classRoom')
            ->where('date', $today)
            ->where('status', 'Terlambat')
            ->orderBy('time_in', 'asc')
            ->paginate(6);

        // 5. Data Chart 7 Hari Terakhir (Tren Kehadiran)
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

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $label = Carbon::today()->subDays($i)->translatedFormat('d M');
            $chartLabels[] = $label;

            $trend = $trends->firstWhere('date', $date);
            $chartHadir[] = $trend ? (int) $trend->hadir : 0;
            $chartTerlambat[] = $trend ? (int) $trend->terlambat : 0;
        }

        return view('admin.dashboard', compact(
            'totalStudents', 'totalHadir', 'totalTerlambat', 'totalAlpa', 'totalIzinSakit', 'totalSudahPulang', 'attendancePercentage',
            'recentScans', 'classSummaries', 'lateStudents', 'chartLabels', 'chartHadir', 'chartTerlambat'
        ));
    }

    public function finalize(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $activeStudents = Student::where('is_active', true)->get();
        $countGenerated = 0;

        DB::transaction(function () use ($activeStudents, $today, &$countGenerated) {
            foreach ($activeStudents as $student) {
                $exists = Attendance::where('student_id', $student->id)
                    ->where('date', $today)
                    ->exists();

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
