<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PiketDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $totalStudents = Student::where('is_active', true)->count();
        $totalHadir = Attendance::where('date', $today)->where('status', 'Hadir')->count();
        $totalTerlambat = Attendance::where('date', $today)->where('status', 'Terlambat')->count();
        $totalIzinSakit = Attendance::where('date', $today)->whereIn('status', ['Izin', 'Sakit'])->count();
        $totalAlpa = Attendance::where('date', $today)->where('status', 'Alpa')->count();
        $totalSudahPulang = Attendance::where('date', $today)->whereNotNull('time_out')->count();

        // Feed Scan Terbaru Hari Ini (Maksimal 5 Orang Terakhir)
        $recentScans = Attendance::with(['student.classRoom'])
            ->where('date', $today)
            ->whereNotNull('time_in')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('piket.dashboard', compact(
            'totalStudents', 'totalHadir', 'totalTerlambat', 'totalIzinSakit', 'totalAlpa', 'totalSudahPulang', 'recentScans'
        ));
    }

    public function today(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $query = Attendance::with(['student.classRoom'])
            ->where('date', $today);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $classId = $request->class_id;
            $query->whereHas('student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $attendances = $query->orderBy('updated_at', 'desc')->paginate(10)->withQueryString();

        // Request AJAX (pagination tanpa reload halaman)
        if ($request->ajax()) {
            return view('piket.partials._today_table', compact('attendances'))->render();
        }

        $classes = \App\Models\ClassRoom::orderBy('name')->get();

        $summary = [
            'total_scanned' => Attendance::where('date', $today)->count(),
            'hadir' => Attendance::where('date', $today)->where('status', 'Hadir')->count(),
            'terlambat' => Attendance::where('date', $today)->where('status', 'Terlambat')->count(),
            'sudah_pulang' => Attendance::where('date', $today)->whereNotNull('time_out')->count(),
        ];

        return view('piket.today', compact('attendances', 'classes', 'today', 'summary'));
    }
}
