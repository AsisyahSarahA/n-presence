<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\PermitRequest;
use App\Models\Student;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with('classRoom')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        $classRooms = ClassRoom::orderBy('name', 'asc')->get();

        // Query untuk Riwayat Izin & Sakit
        $historyQuery = Attendance::with('student.classRoom')
            ->whereIn('status', ['Izin', 'Sakit']);

        // Filter Berdasarkan Tanggal (Default 30 Hari Terakhir jika tidak diisi)
        if ($request->filled('filter_start_date')) {
            $historyQuery->whereDate('date', '>=', $request->filter_start_date);
        }
        if ($request->filled('filter_end_date')) {
            $historyQuery->whereDate('date', '<=', $request->filter_end_date);
        }

        // Filter Kelas
        if ($request->filled('filter_class_id')) {
            $historyQuery->whereHas('student', function ($q) use ($request) {
                $q->where('class_room_id', $request->filter_class_id);
            });
        }

        // Filter Status (Izin / Sakit)
        if ($request->filled('filter_status')) {
            $historyQuery->where('status', $request->filter_status);
        }

        // Filter Pencarian Nama / NISN
        if ($request->filled('search')) {
            $search = $request->search;
            $historyQuery->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $permitsHistory = $historyQuery->orderBy('date', 'desc')->paginate(15)->withQueryString();

        // Query Pengajuan Izin Menunggu Persetujuan (Pending Parent Requests)
        $pendingRequests = PermitRequest::with('student.classRoom')
            ->where('approval_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.permits.index', compact(
            'students',
            'classRooms',
            'permitsHistory',
            'pendingRequests'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'required|in:Izin,Sakit',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'required|string|max:500',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:2048',
        ]);

        $student = Student::findOrFail($request->student_id);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'permit_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/permits');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $attachmentPath = 'uploads/permits/' . $filename;
        }

        $period = CarbonPeriod::create($request->start_date, $request->end_date);
        $countDays = 0;

        foreach ($period as $date) {
            $dateStr = $date->toDateString();

            Attendance::updateOrCreate(
                ['student_id' => $student->id, 'date' => $dateStr],
                [
                    'time_in' => null,
                    'time_out' => null,
                    'status' => $request->status,
                    'late_duration_minutes' => 0,
                    'scanned_by' => auth()->id(),
                    'notes' => $request->notes,
                    'attachment' => $attachmentPath,
                ]
            );
            $countDays++;
        }

        return redirect()->route('admin.permits.index')
            ->with('success', "Data {$request->status} untuk {$student->name} berhasil dicatat selama {$countDays} hari ({$request->start_date} s/d {$request->end_date}).");
    }

    public function approve($id)
    {
        $permitReq = PermitRequest::with('student')->findOrFail($id);

        if ($permitReq->approval_status !== 'pending') {
            return redirect()->route('admin.permits.index')->with('error', 'Pengajuan izin ini sudah diproses sebelumnya.');
        }

        $period = CarbonPeriod::create($permitReq->start_date, $permitReq->end_date);
        $countDays = 0;

        foreach ($period as $date) {
            $dateStr = $date->toDateString();

            Attendance::updateOrCreate(
                ['student_id' => $permitReq->student_id, 'date' => $dateStr],
                [
                    'time_in' => null,
                    'time_out' => null,
                    'status' => $permitReq->status_type,
                    'late_duration_minutes' => 0,
                    'scanned_by' => auth()->id(),
                    'notes' => "[Disetujui dari Wali: {$permitReq->parent_name}] " . $permitReq->notes,
                    'attachment' => $permitReq->attachment,
                ]
            );
            $countDays++;
        }

        $permitReq->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.permits.index')
            ->with('success', "Pengajuan {$permitReq->status_type} untuk {$permitReq->student->name} telah DISETUJUI ({$countDays} hari terabsensi).");
    }

    public function reject(Request $request, $id)
    {
        $permitReq = PermitRequest::with('student')->findOrFail($id);

        $permitReq->update([
            'approval_status' => 'rejected',
            'rejected_reason' => $request->input('rejected_reason', 'Pengajuan ditolak oleh administrator/piket.'),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.permits.index')
            ->with('success', "Pengajuan {$permitReq->status_type} untuk {$permitReq->student->name} telah DITOLAK.");
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $studentName = $attendance->student->name ?? 'Siswa';
        $date = $attendance->date->format('Y-m-d');

        $attendance->delete();

        return redirect()->route('admin.permits.index')
            ->with('success', "Data izin/sakit untuk {$studentName} pada tanggal {$date} telah dihapus.");
    }
}
