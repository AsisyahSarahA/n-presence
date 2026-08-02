<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'daily');
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->get();
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();

        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');
        $appName = Setting::get('app_name', 'N-Presence');

        // =============================================
        // 1. LAPORAN HARIAN
        // =============================================
        $dailyDate = $request->input('daily_date', Carbon::today()->toDateString());
        $dailyClassId = $request->input('daily_class_id', $classes->first()?->id);
        $dailyClass = $dailyClassId ? ClassRoom::find($dailyClassId) : null;

        $dailyAttendances = collect();
        $dailySummary = ['total' => 0, 'hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0];

        if ($dailyClassId) {
            $dailyAttendances = Attendance::with('student')
                ->where('date', $dailyDate)
                ->whereHas('student', function ($query) use ($dailyClassId) {
                    $query->where('class_id', $dailyClassId)->where('is_active', true);
                })
                ->get();

            $dailySummary['total'] = $dailyAttendances->count();
            $dailySummary['hadir'] = $dailyAttendances->filter(fn($att) => $att->effective_status === 'Hadir')->count();
            $dailySummary['terlambat'] = $dailyAttendances->filter(fn($att) => $att->effective_status === 'Terlambat')->count();
            $dailySummary['izin'] = $dailyAttendances->filter(fn($att) => $att->effective_status === 'Izin')->count();
            $dailySummary['sakit'] = $dailyAttendances->filter(fn($att) => $att->effective_status === 'Sakit')->count();
            $dailySummary['alpa'] = $dailyAttendances->filter(fn($att) => $att->effective_status === 'Alpa')->count();
            $dailySummary['sudah_pulang'] = $dailyAttendances->whereNotNull('time_out')->count();
        }

        // =============================================
        // 2. LAPORAN BULANAN
        // =============================================
        $monthlyMonth = (int)$request->input('monthly_month', Carbon::today()->month);
        $monthlyYear = (int)$request->input('monthly_year', Carbon::today()->year);
        $monthlyClassId = $request->input('monthly_class_id', $classes->first()?->id);
        $monthlyClass = $monthlyClassId ? ClassRoom::find($monthlyClassId) : null;

        $monthlyData = collect();

        if ($monthlyClassId) {
            $students = Student::where('class_id', $monthlyClassId)
                ->where('is_active', true)
                ->orderBy('name', 'asc')
                ->get();

            $monthlyData = $students->map(function ($student) use ($monthlyMonth, $monthlyYear) {
                $attendances = Attendance::where('student_id', $student->id)
                    ->whereMonth('date', $monthlyMonth)
                    ->whereYear('date', $monthlyYear)
                    ->get();

                $hadir = $attendances->filter(fn($a) => $a->effective_status === 'Hadir')->count();
                $terlambat = $attendances->filter(fn($a) => $a->effective_status === 'Terlambat')->count();
                $izin = $attendances->filter(fn($a) => $a->effective_status === 'Izin')->count();
                $sakit = $attendances->filter(fn($a) => $a->effective_status === 'Sakit')->count();
                $alpa = $attendances->filter(fn($a) => $a->effective_status === 'Alpa')->count();

                $totalRecord = $hadir + $terlambat + $izin + $sakit + $alpa;
                $presentCount = $hadir + $terlambat;
                $percentage = $totalRecord > 0 ? round(($presentCount / $totalRecord) * 100, 1) : 0;

                return [
                    'student' => $student,
                    'hadir' => $hadir,
                    'terlambat' => $terlambat,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $totalRecord,
                    'percentage' => $percentage,
                ];
            });
        }

        // =============================================
        // 3. REKAP RAPORT SEMESTER
        // =============================================
        $semesterClassId = $request->input('semester_class_id', $classes->first()?->id);
        $semesterClass = $semesterClassId ? ClassRoom::find($semesterClassId) : null;
        $semesterType = $request->input('semester_type', '1'); // 1 = Ganjil (Juli-Des), 2 = Genap (Jan-Juni)
        $selectedAcademicYearId = $request->input('academic_year_id', $academicYears->where('is_active', true)->first()?->id ?? $academicYears->first()?->id);
        $selectedAcademicYear = AcademicYear::find($selectedAcademicYearId);

        $semesterData = collect();

        if ($semesterClassId) {
            $students = Student::where('class_id', $semesterClassId)
                ->where('is_active', true)
                ->orderBy('name', 'asc')
                ->get();

            // Tentukan rentang bulan semester
            $months = ($semesterType == '1') ? [7, 8, 9, 10, 11, 12] : [1, 2, 3, 4, 5, 6];

            $semesterData = $students->map(function ($student) use ($months) {
                $attendances = Attendance::where('student_id', $student->id)
                    ->whereIn(DB::raw('MONTH(date)'), $months)
                    ->get();

                $sakit = $attendances->filter(fn($a) => $a->effective_status === 'Sakit')->count();
                $izin = $attendances->filter(fn($a) => $a->effective_status === 'Izin')->count();
                $alpa = $attendances->filter(fn($a) => $a->effective_status === 'Alpa')->count();

                return [
                    'student' => $student,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpa' => $alpa,
                ];
            });
        }

        return view('admin.reports.index', compact(
            'tab',
            'classes',
            'academicYears',
            'schoolName',
            'appName',
            // Daily
            'dailyDate',
            'dailyClassId',
            'dailyClass',
            'dailyAttendances',
            'dailySummary',
            // Monthly
            'monthlyMonth',
            'monthlyYear',
            'monthlyClassId',
            'monthlyClass',
            'monthlyData',
            // Semester
            'semesterClassId',
            'semesterClass',
            'semesterType',
            'selectedAcademicYearId',
            'selectedAcademicYear',
            'semesterData'
        ));
    }

    public function printDaily(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $classId = $request->input('class_id');
        $class = ClassRoom::with('academicYear')->findOrFail($classId);

        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');
        $appName = Setting::get('app_name', 'N-Presence');

        $attendances = Attendance::with('student')
            ->where('date', $date)
            ->whereHas('student', function ($q) use ($classId) {
                $q->where('class_id', $classId)->where('is_active', true);
            })
            ->get();

        return view('admin.reports.print_daily', compact('date', 'class', 'schoolName', 'appName', 'attendances'));
    }

    public function printMonthly(Request $request)
    {
        $month = (int)$request->input('month', Carbon::today()->month);
        $year = (int)$request->input('year', Carbon::today()->year);
        $classId = $request->input('class_id');
        $class = ClassRoom::with('academicYear')->findOrFail($classId);

        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');
        $appName = Setting::get('app_name', 'N-Presence');

        $students = Student::where('class_id', $classId)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        $monthlyData = $students->map(function ($student) use ($month, $year) {
            $attendances = Attendance::where('student_id', $student->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $hadir = $attendances->filter(fn($a) => $a->effective_status === 'Hadir')->count();
            $terlambat = $attendances->filter(fn($a) => $a->effective_status === 'Terlambat')->count();
            $izin = $attendances->filter(fn($a) => $a->effective_status === 'Izin')->count();
            $sakit = $attendances->filter(fn($a) => $a->effective_status === 'Sakit')->count();
            $alpa = $attendances->filter(fn($a) => $a->effective_status === 'Alpa')->count();

            $totalRecord = $hadir + $terlambat + $izin + $sakit + $alpa;
            $presentCount = $hadir + $terlambat;
            $percentage = $totalRecord > 0 ? round(($presentCount / $totalRecord) * 100, 1) : 0;

            return [
                'student' => $student,
                'hadir' => $hadir,
                'terlambat' => $terlambat,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'total' => $totalRecord,
                'percentage' => $percentage,
            ];
        });

        return view('admin.reports.print_monthly', compact('month', 'year', 'class', 'schoolName', 'appName', 'monthlyData'));
    }

    public function printSemester(Request $request)
    {
        $classId = $request->input('class_id');
        $semesterType = $request->input('semester_type', '1');
        $academicYearId = $request->input('academic_year_id');

        $class = ClassRoom::with('academicYear')->findOrFail($classId);
        $academicYear = AcademicYear::find($academicYearId) ?? $class->academicYear;

        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');
        $appName = Setting::get('app_name', 'N-Presence');

        $students = Student::where('class_id', $classId)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        $months = ($semesterType == '1') ? [7, 8, 9, 10, 11, 12] : [1, 2, 3, 4, 5, 6];

        $semesterData = $students->map(function ($student) use ($months) {
            $attendances = Attendance::where('student_id', $student->id)
                ->whereIn(DB::raw('MONTH(date)'), $months)
                ->get();

            return [
                'student' => $student,
                'sakit' => $attendances->filter(fn($a) => $a->effective_status === 'Sakit')->count(),
                'izin' => $attendances->filter(fn($a) => $a->effective_status === 'Izin')->count(),
                'alpa' => $attendances->filter(fn($a) => $a->effective_status === 'Alpa')->count(),
            ];
        });

        return view('admin.reports.print_semester', compact('semesterType', 'academicYear', 'class', 'schoolName', 'appName', 'semesterData'));
    }
}
