<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    public function index()
    {
        $students = Student::with('classRoom.academicYear')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.permits.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'student_id' => 'required|exists:students,id',
            'status' => 'required|in:Izin,Sakit',
            'notes' => 'required|string|max:500',
        ]);

        $student = Student::findOrFail($request->student_id);

        Attendance::updateOrCreate(
            ['student_id' => $student->id, 'date' => $request->date],
            [
                'time_in' => null,
                'time_out' => null,
                'status' => $request->status,
                'late_duration_minutes' => 0,
                'scanned_by' => auth()->id(),
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('admin.permits.index')
            ->with('success', "Data {$request->status} untuk {$student->name} pada tanggal {$request->date} berhasil disimpan.");
    }
}
