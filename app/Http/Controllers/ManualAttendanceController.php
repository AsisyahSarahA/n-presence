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
        $search = $request->input('search');
        $statusFilter = $request->input('status_filter');

        $students = collect();
        $summary = [
            'total' => 0,
            'hadir' => 0,
            'terlambat' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'belum_absen' => 0,
            'sudah_pulang' => 0,
        ];

        if ($classId) {
            // Full list for summary statistics
            $allStudents = Student::select(
                'students.id',
                'attendances.status as attendance_status',
                'attendances.time_out as attendance_time_out'
            )
                ->leftJoin('attendances', function ($join) use ($date) {
                    $join->on('students.id', '=', 'attendances.student_id')
                        ->where('attendances.date', '=', $date);
                })
                ->where('students.class_id', $classId)
                ->where('students.is_active', true)
                ->get();

            $summary['total'] = $allStudents->count();
            $summary['hadir'] = $allStudents->where('attendance_status', 'Hadir')->count();
            $summary['terlambat'] = $allStudents->where('attendance_status', 'Terlambat')->count();
            $summary['izin'] = $allStudents->where('attendance_status', 'Izin')->count();
            $summary['sakit'] = $allStudents->where('attendance_status', 'Sakit')->count();
            $summary['alpa'] = $allStudents->where('attendance_status', 'Alpa')->count();
            $summary['belum_absen'] = $allStudents->whereNull('attendance_status')->count();
            $summary['sudah_pulang'] = $allStudents->whereNotNull('attendance_time_out')->count();

            // Filtered Query for Student Table List
            $query = Student::select(
                'students.id',
                'students.nisn',
                'students.name',
                'attendances.id as attendance_id',
                'attendances.status as attendance_status',
                'attendances.notes as attendance_notes',
                'attendances.time_in as attendance_time_in',
                'attendances.time_out as attendance_time_out'
            )
                ->leftJoin('attendances', function ($join) use ($date) {
                    $join->on('students.id', '=', 'attendances.student_id')
                        ->where('attendances.date', '=', $date);
                })
                ->where('students.class_id', $classId)
                ->where('students.is_active', true);

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('students.name', 'like', "%{$search}%")
                      ->orWhere('students.nisn', 'like', "%{$search}%");
                });
            }

            if ($statusFilter) {
                if ($statusFilter === 'Belum Absen') {
                    $query->whereNull('attendances.status');
                } elseif ($statusFilter === 'Sudah Pulang') {
                    $query->whereNotNull('attendances.time_out');
                } elseif ($statusFilter === 'Belum Pulang') {
                    $query->whereIn('attendances.status', ['Hadir', 'Terlambat'])
                          ->whereNull('attendances.time_out');
                } else {
                    $query->where('attendances.status', $statusFilter);
                }
            }

            $students = $query->orderBy('students.name')->get();
        }

        return view('admin.attendances.manual', compact('classes', 'date', 'classId', 'students', 'summary', 'search', 'statusFilter'));
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
                $data['is_admin_override'] = true;
                if (!$existing || !$existing->time_in) {
                    $data['time_in'] = now()->format('H:i:s');
                }
            } else {
                $data['is_admin_override'] = false;
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
