<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PermitController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes — N-Presence
|--------------------------------------------------------------------------
*/

// =============================================
// PUBLIC PERMIT REQUEST (Pengajuan Wali Murid)
// =============================================
Route::get('/pengajuan-izin', [\App\Http\Controllers\PublicPermitController::class, 'create'])->name('public.permits.create');
Route::post('/pengajuan-izin', [\App\Http\Controllers\PublicPermitController::class, 'store'])->name('public.permits.store');

// =============================================
// AUTH ROUTES (Public)
// =============================================
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isAdmin() 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('piket.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =============================================
// ADMIN ROUTES (Role: admin)
// =============================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/finalize', [DashboardController::class, 'finalize'])->name('dashboard.finalize');

        // CRUD Tahun Ajaran
        Route::get('/academic-years', [AcademicYearController::class, 'index'])->name('academic-years.index');
        Route::post('/academic-years', [AcademicYearController::class, 'store'])->name('academic-years.store');
        Route::put('/academic-years/{id}', [AcademicYearController::class, 'update'])->name('academic-years.update');
        Route::delete('/academic-years/{id}', [AcademicYearController::class, 'destroy'])->name('academic-years.destroy');

        // CRUD Kelas
        Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
        Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
        Route::put('/classes/{id}', [ClassController::class, 'update'])->name('classes.update');
        Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');

        // CRUD Siswa
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        // Cetak Kartu QR
        Route::get('/qr-cards', [CardController::class, 'index'])->name('qr-cards.index');
        Route::get('/qr-cards/print/{class_id}', [CardController::class, 'print'])->name('qr-cards.print');
        Route::get('/qr-cards/print-single/{student_id}', [CardController::class, 'printSingle'])->name('qr-cards.print-single');

        // Laporan & Rekap
        Route::get('/reports/daily', [ReportController::class, 'index'])->name('reports.daily');
        Route::get('/reports/print-daily', [ReportController::class, 'printDaily'])->name('reports.print_daily');
        Route::get('/reports/print-monthly', [ReportController::class, 'printMonthly'])->name('reports.print_monthly');
        Route::get('/reports/print-semester', [ReportController::class, 'printSemester'])->name('reports.print_semester');
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');

        // Pengaturan
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Izin & Sakit
        Route::get('/permits', [PermitController::class, 'index'])->name('permits.index');
        Route::post('/permits', [PermitController::class, 'store'])->name('permits.store');
        Route::post('/permits/{id}/approve', [PermitController::class, 'approve'])->name('permits.approve');
        Route::post('/permits/{id}/reject', [PermitController::class, 'reject'])->name('permits.reject');
        Route::delete('/permits/{id}', [PermitController::class, 'destroy'])->name('permits.destroy');

        // Manajemen Kehadiran Manual per Kelas
        Route::get('/attendances/manual', [\App\Http\Controllers\ManualAttendanceController::class, 'index'])->name('attendances.manual.index');
        Route::post('/attendances/manual', [\App\Http\Controllers\ManualAttendanceController::class, 'store'])->name('attendances.manual.store');

        // CRUD Manajemen User
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });

// =============================================
// PIKET ROUTES (Role: piket)
// =============================================
Route::middleware(['auth', 'role:piket'])
    ->prefix('piket')
    ->name('piket.')
    ->group(function () {

        Route::get('/', [\App\Http\Controllers\PiketDashboardController::class, 'index'])->name('dashboard');
        Route::get('/today', [\App\Http\Controllers\PiketDashboardController::class, 'today'])->name('today');

        Route::get('/scanner', function () {
            return view('piket.scanner');
        })->name('scanner');
    });

// =============================================
// ATTENDANCE SCAN API (via Web route with CSRF)
// =============================================
Route::middleware(['auth', 'role:piket'])->group(function () {
    Route::post('/api/attendance/scan-in', [AttendanceController::class, 'scanIn'])->name('attendance.scan-in');
    Route::post('/api/attendance/scan-out', [AttendanceController::class, 'scanOut'])->name('attendance.scan-out');
});
