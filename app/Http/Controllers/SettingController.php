<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');
        $timeInLimit = Setting::get('time_in_limit', '07:00');
        $timeInTolerance = Setting::get('time_in_tolerance', '07:15');

        return view('admin.settings.index', compact('schoolName', 'timeInLimit', 'timeInTolerance'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:100',
            'time_in_limit' => 'required|date_format:H:i',
            'time_in_tolerance' => 'required|date_format:H:i|after_or_equal:time_in_limit',
        ]);

        Setting::updateOrCreate(['key' => 'school_name'], ['value' => $request->school_name, 'description' => 'Nama Sekolah']);
        Setting::updateOrCreate(['key' => 'time_in_limit'], ['value' => $request->time_in_limit, 'description' => 'Batas Jam Masuk']);
        Setting::updateOrCreate(['key' => 'time_in_tolerance'], ['value' => $request->time_in_tolerance, 'description' => 'Toleransi Jam Masuk']);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
