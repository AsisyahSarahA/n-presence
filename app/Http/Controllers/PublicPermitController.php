<?php

namespace App\Http\Controllers;

use App\Models\PermitRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class PublicPermitController extends Controller
{
    public function create()
    {
        $students = Student::with('classRoom')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('permits.public_create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'parent_name' => 'required|string|max:100',
            'parent_phone' => 'required|string|max:30',
            'status_type' => 'required|in:Izin,Sakit',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'required|string|max:500',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'permit_req_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/permits');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $attachmentPath = 'uploads/permits/' . $filename;
        }

        $permitRequest = PermitRequest::create([
            'student_id' => $request->student_id,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'status_type' => $request->status_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
            'attachment' => $attachmentPath,
            'approval_status' => 'pending',
        ]);

        $student = Student::with('classRoom')->find($request->student_id);

        return redirect()->route('public.permits.create')->with([
            'success' => 'Pengajuan izin/sakit berhasil dikirim! Silakan tunggu konfirmasi dari pihak sekolah.',
            'request_data' => [
                'student_name' => $student->name,
                'class_name' => $student->classRoom->name ?? '-',
                'status_type' => $request->status_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]
        ]);
    }
}
