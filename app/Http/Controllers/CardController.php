<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->get();
        $students = Student::with('classRoom.academicYear')->where('is_active', true)->orderBy('name', 'asc')->get();
        return view('admin.qr-cards.index', compact('classes', 'students'));
    }

    public function print($class_id)
    {
        $class = ClassRoom::with('academicYear')->findOrFail($class_id);
        $students = Student::where('class_id', $class_id)->where('is_active', true)->orderBy('name', 'asc')->get();

        $schoolName = Setting::get('school_name', 'SMPN SATU ATAP 1 CIGALONTANG');
        $appName = Setting::get('app_name', 'N-Presence');
        $appLogo = Setting::get('app_logo', '');

        return view('admin.qr-cards.print', compact('class', 'students', 'schoolName', 'appName', 'appLogo'));
    }

    public function printSingle($student_id)
    {
        $student = Student::with('classRoom.academicYear')->findOrFail($student_id);
        $class = $student->classRoom;
        $students = collect([$student]);

        $schoolName = Setting::get('school_name', 'SMPN SATU ATAP 1 CIGALONTANG');
        $appName = Setting::get('app_name', 'N-Presence');
        $appLogo = Setting::get('app_logo', '');

        return view('admin.qr-cards.print', compact('class', 'students', 'schoolName', 'appName', 'appLogo'));
    }
}
