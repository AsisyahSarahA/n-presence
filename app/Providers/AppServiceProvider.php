<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa skema HTTPS hanya jika request datang dari Ngrok / Reverse Proxy
        if (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            if (Schema::hasTable('settings')) {
                $view->with('appName', Setting::get('app_name', 'N-Presence'));
                $view->with('schoolName', Setting::get('school_name', 'SMPN SATU ATAP 1 CIGALONTANG'));
                $view->with('appDescription', Setting::get('app_description', 'Sistem Absensi SMPN SATU ATAP 1 CIGALONTANG'));
                $view->with('appLogo', Setting::get('app_logo'));
                $view->with('appFooter', Setting::get('app_footer', '© 2026 KKN Kelompok 02 Cigalontang. All rights reserved.'));
                $view->with('timeInLimit', Setting::get('time_in_limit', '07:00'));
                $view->with('timeInTolerance', Setting::get('time_in_tolerance', '07:15'));
                $view->with('timeOutStart', Setting::get('time_out_start', '13:00'));
            }
        });
    }
}
