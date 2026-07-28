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
                ->where(function ($q) {
                    $q->whereNull('attendances.id')
                        ->orWhere('attendances.status', '!=', 'Hadir');
                })
                ->orderBy('students.name')
                ->get();
        }

        return view('admin.attendances.manual', compact('classes', 'date', 'classId', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:Hadir,Sakit,Izin,Alpa',
            'attendances.*.notes' => 'nullable|string|max:255',
        ]);

        $date = $request->date;

        foreach ($request->attendances as $item) {
            $status = $item['status'];
            $existing = Attendance::where('student_id', $item['student_id'])
                ->where('date', $date)
                ->first();

            $data = [
                'status' => $status,
                'notes' => $item['notes'] ?? null,
                'scanned_by' => Auth::id(),
            ];

            if ($status === 'Hadir') {
                if (!$existing || !$existing->time_in) {
                    $data['time_in'] = now();
                }
            } else {
                $data['time_in'] = null;
            }

            Attendance::updateOrCreate(
                ['student_id' => $item['student_id'], 'date' => $date],
                $data
            );
        }

        return redirect()->back()->with('success', 'Data kehadiran berhasil diperbarui.');
    }
}
