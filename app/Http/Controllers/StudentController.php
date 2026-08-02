<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['nisn', 'name', 'class_id', 'gender']);
        $data['is_active'] = true;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $this->uploadAndCompressPhoto($request->file('photo'), $request->nisn);
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['nisn', 'name', 'class_id', 'gender']);

        if ($request->hasFile('photo')) {
            // Hapus foto lama dari storage jika ada
            if ($student->photo_path && Storage::disk('public')->exists($student->photo_path)) {
                Storage::disk('public')->delete($student->photo_path);
            }

            $data['photo_path'] = $this->uploadAndCompressPhoto($request->file('photo'), $request->nisn);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->photo_path && Storage::disk('public')->exists($student->photo_path)) {
            Storage::disk('public')->delete($student->photo_path);
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function show($id)
    {
        $student = Student::with(['classRoom.academicYear'])->findOrFail($id);
        $attendances = $student->attendances()
            ->orderBy('date', 'desc')
            ->paginate(15);

        $summary = [
            'total_records' => $student->attendances()->count(),
            'hadir' => $student->attendances()->where('status', 'Hadir')->count(),
            'terlambat' => $student->attendances()->where('status', 'Terlambat')->count(),
            'izin' => $student->attendances()->where('status', 'Izin')->count(),
            'sakit' => $student->attendances()->where('status', 'Sakit')->count(),
            'alpa' => $student->attendances()->where('status', 'Alpa')->count(),
        ];

        return view('admin.students.show', compact('student', 'attendances', 'summary'));
    }

    /**
     * Compress & Resize uploaded student photo using Intervention Image
     * Resizes to 500x500 square ratio, converts to .webp format at 75% quality.
     */
    private function uploadAndCompressPhoto($file, string $nisn): string
    {
        try {
            $filename = 'photo_' . time() . '_' . md5($nisn . microtime()) . '.webp';
            $manager = new ImageManager(new Driver());

            if (method_exists($manager, 'read')) {
                $image = $manager->read($file->getRealPath());
            } else {
                $image = $manager->decodePath($file->getRealPath());
            }

            // Resize & Crop ke rasio persegi 500x500px
            $image->cover(500, 500);

            // Kompresi ke format WebP kualitas 75%
            if (class_exists(WebpEncoder::class)) {
                $encoded = $image->encode(new WebpEncoder(quality: 75));
            } else {
                $encoded = $image->encodeUsingFileExtension('webp', quality: 75);
            }

            $path = 'photos/' . $filename;
            Storage::disk('public')->put($path, (string) $encoded);

            return $path;
        } catch (\Throwable $e) {
            Log::error('Intervention Image Compression Error: ' . $e->getMessage());
            // Fallback aman: Simpan file biasa jika kompresi gagal
            $filename = time() . '_' . $nisn . '.' . $file->getClientOriginalExtension();
            return $file->storeAs('photos', $filename, 'public');
        }
    }
}
