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

        // Feed Scan Terbaru Hari Ini
        $recentScans = Attendance::with(['student.classRoom'])
            ->where('date', $today)
            ->whereNotNull('time_in')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('piket.dashboard', compact(
            'totalStudents', 'totalHadir', 'totalTerlambat', 'totalIzinSakit', 'totalAlpa', 'recentScans'
        ));
    }
}
