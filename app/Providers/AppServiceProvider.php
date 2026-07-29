<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
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
        View::composer('*', function ($view) {
            if (Schema::hasTable('settings')) {
                $view->with('appName', Setting::get('app_name', 'N-Presence'));
                $view->with('schoolName', Setting::get('school_name', 'SMP Negeri Nangtang'));
                $view->with('appDescription', Setting::get('app_description', 'Sistem Absensi SMP Negeri Nangtang'));
                $view->with('appLogo', Setting::get('app_logo'));
                $view->with('appFooter', Setting::get('app_footer', '© 2026 KKN Kelompok 02 Nangtang. All rights reserved.'));
            }
        });
    }
}
