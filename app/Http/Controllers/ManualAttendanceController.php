<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManualAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = ClassRoom::orderBy('name')->get();

        $date = $request->input('date', now()->toDateString());
        $classId = $request->input('class_id');

        $students = collect();
        $summary = [
            'total' => 0,
            'hadir' => 0,
            'terlambat' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'belum_absen' => 0,
        ];

        if ($classId) {
            $students = Student::select(
                'students.id',
                'students.nisn',
                'students.name',
                'attendances.id as attendance_id',
                'attendances.status as attendance_status',
                'attendances.notes as attendance_notes',
                'attendances.time_in as attendance_time_in'
            )
                ->leftJoin('attendances', function ($join) use ($date) {
                    $join->on('students.id', '=', 'attendances.student_id')
                        ->where('attendances.date', '=', $date);
                })
                ->where('students.class_id', $classId)
                ->where('students.is_active', true)
                ->orderBy('students.name')
                ->get();

            $summary['total'] = $students->count();
            $summary['hadir'] = $students->where('attendance_status', 'Hadir')->count();
            $summary['terlambat'] = $students->where('attendance_status', 'Terlambat')->count();
            $summary['izin'] = $students->where('attendance_status', 'Izin')->count();
            $summary['sakit'] = $students->where('attendance_status', 'Sakit')->count();
            $summary['alpa'] = $students->where('attendance_status', 'Alpa')->count();
            $summary['belum_absen'] = $students->whereNull('attendance_status')->count();
        }

        return view('admin.attendances.manual', compact('classes', 'date', 'classId', 'students', 'summary'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'nullable|in:Hadir,Terlambat,Sakit,Izin,Alpa',
            'attendances.*.notes' => 'nullable|string|max:255',
        ]);

        $date = $request->date;
        $updatedCount = 0;

        foreach ($request->attendances as $item) {
            $status = $item['status'] ?? null;
            
            if (!$status) {
                // Jika status di-uncheck atau dibosongkan, hapus data absensi jika ada
                Attendance::where('student_id', $item['student_id'])
                    ->where('date', $date)
                    ->delete();
                continue;
            }

            $existing = Attendance::where('student_id', $item['student_id'])
                ->where('date', $date)
                ->first();

            $data = [
                'status' => $status,
                'notes' => $item['notes'] ?? null,
                'scanned_by' => Auth::id(),
            ];

            if ($status === 'Hadir' || $status === 'Terlambat') {
                if (!$existing || !$existing->time_in) {
                    $data['time_in'] = now()->format('H:i:s');
                }
            } else {
                $data['time_in'] = null;
                $data['time_out'] = null;
            }

            Attendance::updateOrCreate(
                ['student_id' => $item['student_id'], 'date' => $date],
                $data
            );
            $updatedCount++;
        }

        return redirect()->back()->with('success', "Berhasil memperbarui data presensi untuk {$updatedCount} siswa.");
    }
}
