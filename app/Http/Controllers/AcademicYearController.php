<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderBy('name', 'desc')->paginate(7);
        return view('admin.academic-years.index', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'sometimes|boolean',
        ]);

        $isActive = $request->boolean('is_active');

        DB::transaction(function () use ($request, $isActive) {
            if ($isActive) {
                // Nonaktifkan semua tahun ajaran lain
                AcademicYear::query()->update(['is_active' => false]);
            }

            AcademicYear::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $isActive,
            ]);
        });

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'sometimes|boolean',
        ]);

        $year = AcademicYear::findOrFail($id);
        $isActive = $request->boolean('is_active');

        DB::transaction(function () use ($year, $request, $isActive) {
            if ($isActive) {
                // Nonaktifkan semua tahun ajaran lain
                AcademicYear::where('id', '!=', $year->id)->update(['is_active' => false]);
            }

            $year->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $isActive,
            ]);
        });

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $year = AcademicYear::findOrFail($id);
        
        if ($year->is_active) {
            return redirect()->route('admin.academic-years.index')->with('error', 'Tahun ajaran yang aktif tidak boleh dihapus.');
        }

        $year->delete();
        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
