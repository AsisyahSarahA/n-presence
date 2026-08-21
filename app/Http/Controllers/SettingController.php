<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $appName = Setting::get('app_name', 'N-Presence');
        $schoolName = Setting::get('school_name', 'SMPN SATU ATAP 1 CIGALONTANG');
        $appDescription = Setting::get('app_description', 'Sistem Absensi SMPN SATU ATAP 1 CIGALONTANG');
        $appLogo = Setting::get('app_logo');
        $appFooter = Setting::get('app_footer', '© 2026 KKN Kelompok 02 Cigalontang. All rights reserved.');
        $timeInLimit = Setting::get('time_in_limit', '07:00');
        $timeInTolerance = Setting::get('time_in_tolerance', '07:15');
        $timeOutStart = Setting::get('time_out_start', '13:00');

        return view('admin.settings.index', compact(
            'appName',
            'schoolName',
            'appDescription',
            'appLogo',
            'appFooter',
            'timeInLimit',
            'timeInTolerance',
            'timeOutStart'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'school_name' => 'required|string|max:100',
            'app_description' => 'nullable|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'remove_logo' => 'nullable|boolean',
            'time_in_limit' => ['required', 'regex:/^(?:2[0-3]|[01][0-9]):[0-5][0-9](?::[0-5][0-9])?$/'],
            'time_in_tolerance' => ['required', 'regex:/^(?:2[0-3]|[01][0-9]):[0-5][0-9](?::[0-5][0-9])?$/'],
            'time_out_start' => ['required', 'regex:/^(?:2[0-3]|[01][0-9]):[0-5][0-9](?::[0-5][0-9])?$/'],
        ]);

        $timeInLimit = substr($request->time_in_limit, 0, 5);
        $timeInTolerance = substr($request->time_in_tolerance, 0, 5);
        $timeOutStart = substr($request->time_out_start, 0, 5);

        Setting::updateOrCreate(['key' => 'app_name'], ['value' => $request->app_name, 'description' => 'Nama Aplikasi']);
        Setting::updateOrCreate(['key' => 'school_name'], ['value' => $request->school_name, 'description' => 'Nama Sekolah']);
        Setting::updateOrCreate(['key' => 'app_description'], ['value' => $request->app_description, 'description' => 'Deskripsi / Subtitle Aplikasi']);
        Setting::updateOrCreate(['key' => 'app_footer'], ['value' => '© 2026 KKN Kelompok 02 Nangtang. All rights reserved.', 'description' => 'Teks Footer Aplikasi']);
        Setting::updateOrCreate(['key' => 'time_in_limit'], ['value' => $timeInLimit, 'description' => 'Batas Jam Masuk']);
        Setting::updateOrCreate(['key' => 'time_in_tolerance'], ['value' => $timeInTolerance, 'description' => 'Toleransi Jam Masuk']);
        Setting::updateOrCreate(['key' => 'time_out_start'], ['value' => $timeOutStart, 'description' => 'Batas Jam Mulai Scan Pulang']);

        \Illuminate\Support\Facades\Cache::forget('time_in_limit');
        \Illuminate\Support\Facades\Cache::forget('time_in_tolerance');
        \Illuminate\Support\Facades\Cache::forget('time_out_start');

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

