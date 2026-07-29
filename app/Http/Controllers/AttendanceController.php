<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function scanIn(Request $request): JsonResponse
    {
        $request->validate(['nisn' => 'required|string']);

        $student = Student::where('nisn', $request->nisn)->where('is_active', true)->first();
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan atau tidak aktif.'], 404);
        }
        $today = now()->toDateString();

        $existing = Attendance::where('student_id', $student->id)->where('date', $today)->first();
        if ($existing && in_array($existing->status, ['Izin', 'Sakit', 'Alpa'])) {
            return response()->json([
                'status' => 'error',
                'message' => "Siswa ini sudah tercatat {$existing->status} hari ini. Kartu tidak dapat digunakan."
            ], 409);
        }

        if ($existing && $existing->time_in) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa ini sudah melakukan scan masuk hari ini pukul ' . Carbon::parse($existing->time_in)->format('H:i') . '.'
            ], 409);
        }

        $timeIn = now();
        $lateLimit = Setting::get('time_in_limit', '07:00');
        $lateDuration = null;
        $status = 'Hadir';

        $limitTime = Carbon::parse($lateLimit);
        if ($timeIn->greaterThan($limitTime)) {
            $lateDuration = (int) $limitTime->diffInMinutes($timeIn);
            $status = 'Terlambat';
        }

        $motivationHadir = 'Keren! Terima kasih sudah datang tepat waktu hari ini. Tetap semangat belajarnya ya! 🌟';
        $motivationTelat = 'Yah, kamu terlambat. Tapi nggak apa-apa, lebih baik terlambat daripada tidak datang. Besok bangun lebih pagi ya! 💪';
        $motivationPulang = 'Selamat istirahat! Hati-hati di jalan pulang ya. Sampai jumpa besok! 🏡';

        Attendance::updateOrCreate(
            ['student_id' => $student->id, 'date' => $today],
            [
                'time_in' => $timeIn,
                'status' => $status,
                'late_duration_minutes' => $lateDuration ?? 0,
                'scanned_by' => Auth::id(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'scan_type' => 'in',
            'student_name' => $student->name,
            'student_nisn' => $student->nisn,
            'student_class' => $student->classRoom->name ?? '-',
            'student_photo' => $student->photo_path ? asset('storage/' . $student->photo_path) : null,
            'attendance_status' => $status,
            'late_duration' => $lateDuration ? "{$lateDuration}" : '0',
            'motivation_text' => $status === 'Terlambat' ? $motivationTelat : $motivationHadir,
        ]);
    }

    public function scanOut(Request $request): JsonResponse
    {
        $request->validate(['nisn' => 'required|string']);

        $student = Student::where('nisn', $request->nisn)->where('is_active', true)->first();
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan atau tidak aktif.'], 404);
        }

        $today = now()->toDateString();
        $attendance = Attendance::where('student_id', $student->id)->where('date', $today)->first();

        if (!$attendance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa ini belum melakukan scan masuk hari ini. Scan pulang tidak dapat dilakukan.'
            ], 409);
        }

        if ($attendance->time_out) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa ini sudah melakukan scan pulang hari ini pukul ' . Carbon::parse($attendance->time_out)->format('H:i') . '.'
            ], 409);
        }

        $attendance->update([
            'time_out' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'scan_type' => 'out',
            'student_name' => $student->name,
            'student_nisn' => $student->nisn,
            'student_class' => $student->classRoom->name ?? '-',
            'student_photo' => $student->photo_path ? asset('storage/' . $student->photo_path) : null,
            'attendance_status' => 'Hadir',
            'late_duration' => $attendance->late_duration_minutes ? "{$attendance->late_duration_minutes}" : '0',
            'motivation_text' => 'Selamat istirahat! Hati-hati di jalan pulang ya. Sampai jumpa besok! 🏡',
        ]);
    }
}