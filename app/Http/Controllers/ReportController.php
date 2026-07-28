<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\Setting;
use App\Exports\DailyAttendanceExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function dailyReport(Request $request)
    {
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->get();
        
        $date = $request->input('date', Carbon::today()->toDateString());
        $classId = $request->input('class_id');

        $attendances = collect();
        $selectedClass = null;

        if ($classId) {
            $selectedClass = ClassRoom::findOrFail($classId);
            
            // Ambil absensi siswa di kelas terpilih pada tanggal tertentu
            $attendances = Attendance::with('student')
                ->where('date', $date)
                ->whereHas('student', function ($query) use ($classId) {
                    $query->where('class_id', $classId);
                })
                ->paginate(7);
        } else {
            $attendances = collect();
        }

        return view('admin.reports.daily', compact('classes', 'attendances', 'date', 'classId', 'selectedClass'));
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
        ]);

        $date = $request->date;
        $classId = $request->class_id;

        $classRoom = ClassRoom::findOrFail($classId);
        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');

        $attendances = Attendance::with('student')
            ->where('date', $date)
            ->whereHas('student', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->get();

        $fileName = 'rekap_absen_' . $classRoom->name . '_' . $date . '.xlsx';

        return Excel::download(new DailyAttendanceExport($attendances, $date, $classRoom, $schoolName), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
        ]);

        $date = $request->date;
        $classId = $request->class_id;

        $classRoom = ClassRoom::findOrFail($classId);
        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');

        $attendances = Attendance::with('student')
            ->where('date', $date)
            ->whereHas('student', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->get();

        $pdf = Pdf::loadView('exports.daily-pdf', compact('attendances', 'date', 'classRoom', 'schoolName'));
        
        $fileName = 'rekap_absen_' . $classRoom->name . '_' . $date . '.pdf';
        
        return $pdf->download($fileName);
    }
}
