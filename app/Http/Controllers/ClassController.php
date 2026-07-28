<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->paginate(7);
        $academicYears = AcademicYear::all();
        return view('admin.classes.index', compact('classes', 'academicYears'));
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
