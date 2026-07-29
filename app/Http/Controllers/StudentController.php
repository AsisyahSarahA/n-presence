<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('classRoom.academicYear');

        // Filter Pencarian (Nama / NISN)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Filter Kelas
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter Gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $students = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->get();

        $stats = [
            'total' => Student::count(),
            'active' => Student::where('is_active', true)->count(),
            'male' => Student::where('gender', 'L')->count(),
            'female' => Student::where('gender', 'P')->count(),
        ];

        return view('admin.students.index', compact('students', 'classes', 'stats'));
    }

    public function create()
    {
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->get();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:students,nisn',
            'name' => 'required|string|max:100',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nisn', 'name', 'class_id', 'gender']);
        $data['is_active'] = true;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $request->nisn . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos', $filename, 'public');
            $data['photo_path'] = $path;
        }

        Student::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = ClassRoom::with('academicYear')->orderBy('name', 'asc')->get();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'name' => 'required|string|max:100',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nisn', 'name', 'class_id', 'gender']);

        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $request->nisn . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos', $filename, 'public');
            $data['photo_path'] = $path;
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
