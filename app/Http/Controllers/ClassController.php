<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with('academicYear')->withCount('students');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('homeroom_teacher', 'like', "%{$search}%");
            });
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $classes = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();

        $stats = [
            'total_classes' => ClassRoom::count(),
            'total_students' => Student::where('is_active', true)->count(),
            'teacher_assigned' => ClassRoom::whereNotNull('homeroom_teacher')->where('homeroom_teacher', '!=', '')->count(),
        ];

        return view('admin.classes.index', compact('classes', 'academicYears', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'academic_year_id' => 'required|exists:academic_years,id',
            'homeroom_teacher' => 'nullable|string|max:100',
        ]);

        ClassRoom::create($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'academic_year_id' => 'required|exists:academic_years,id',
            'homeroom_teacher' => 'nullable|string|max:100',
        ]);

        $class = ClassRoom::findOrFail($id);
        $class->update($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $class = ClassRoom::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
