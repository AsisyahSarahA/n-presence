<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $appName = Setting::get('app_name', 'N-Presence');
        $schoolName = Setting::get('school_name', 'SMP Negeri Nangtang');
        $appDescription = Setting::get('app_description', 'Sistem Absensi SMP Negeri Nangtang');
        $appLogo = Setting::get('app_logo');
        $appFooter = Setting::get('app_footer', '© 2026 KKN Kelompok 02 Nangtang. All rights reserved.');
        $timeInLimit = Setting::get('time_in_limit', '07:00');
        $timeInTolerance = Setting::get('time_in_tolerance', '07:15');

        return view('admin.settings.index', compact(
            'appName',
            'schoolName',
            'appDescription',
            'appLogo',
            'appFooter',
            'timeInLimit',
            'timeInTolerance'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'school_name' => 'required|string|max:100',
            'app_description' => 'nullable|string|max:255',
            'app_footer' => 'nullable|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'remove_logo' => 'nullable|boolean',
            'time_in_limit' => 'required|date_format:H:i',
            'time_in_tolerance' => 'required|date_format:H:i|after_or_equal:time_in_limit',
        ]);

        Setting::updateOrCreate(['key' => 'app_name'], ['value' => $request->app_name, 'description' => 'Nama Aplikasi']);
        Setting::updateOrCreate(['key' => 'school_name'], ['value' => $request->school_name, 'description' => 'Nama Sekolah']);
        Setting::updateOrCreate(['key' => 'app_description'], ['value' => $request->app_description, 'description' => 'Deskripsi / Subtitle Aplikasi']);
        Setting::updateOrCreate(['key' => 'app_footer'], ['value' => $request->app_footer, 'description' => 'Teks Footer Aplikasi']);
        Setting::updateOrCreate(['key' => 'time_in_limit'], ['value' => $request->time_in_limit, 'description' => 'Batas Jam Masuk']);
        Setting::updateOrCreate(['key' => 'time_in_tolerance'], ['value' => $request->time_in_tolerance, 'description' => 'Toleransi Jam Masuk']);

        $currentLogo = Setting::get('app_logo');

        if ($request->boolean('remove_logo')) {
            if ($currentLogo && file_exists(public_path($currentLogo))) {
                @unlink(public_path($currentLogo));
            }
            Setting::updateOrCreate(['key' => 'app_logo'], ['value' => '', 'description' => 'Logo Aplikasi']);
        } elseif ($request->hasFile('app_logo')) {
            if ($currentLogo && file_exists(public_path($currentLogo))) {
                @unlink(public_path($currentLogo));
            }

            $file = $request->file('app_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/branding');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $logoPath = 'uploads/branding/' . $filename;

            Setting::updateOrCreate(['key' => 'app_logo'], ['value' => $logoPath, 'description' => 'Logo Aplikasi']);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem & branding berhasil diperbarui.');
    }
}

