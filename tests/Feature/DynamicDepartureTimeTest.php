<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicDepartureTimeTest extends TestCase
{
    use RefreshDatabase;

    private User $piket;
    private User $admin;
    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->piket = User::create([
            'name' => 'Piket Test',
            'username' => 'piket_test',
            'password' => bcrypt('password123'),
            'role' => 'piket',
        ]);

        $academicYear = AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        $class = ClassRoom::create([
            'name' => 'VII A',
            'academic_year_id' => $academicYear->id,
            'homeroom_teacher' => 'Wali Kelas',
        ]);

        $this->student = Student::create([
            'nisn' => '9999999999',
            'name' => 'Budi Santoso',
            'class_id' => $class->id,
            'gender' => 'L',
            'is_active' => true,
        ]);

        Setting::updateOrCreate(['key' => 'time_in_limit'], ['value' => '07:00']);
        Setting::updateOrCreate(['key' => 'time_in_tolerance'], ['value' => '07:15']);
        Setting::updateOrCreate(['key' => 'time_out_start'], ['value' => '13:00']);
    }

    public function test_student_cannot_scan_out_if_not_scanned_in_yet(): void
    {
        $response = $this->actingAs($this->piket)->postJson('/api/attendance/scan-out', [
            'nisn' => $this->student->nisn,
        ]);

        $response->assertStatus(409)
            ->assertJson([
                'status' => 'error',
                'message' => 'Siswa ini belum melakukan scan masuk hari ini. Scan pulang tidak dapat dilakukan.',
            ]);
    }

    public function test_student_cannot_scan_out_before_departure_time(): void
    {
        $today = now()->toDateString();
        Attendance::create([
            'student_id' => $this->student->id,
            'date' => $today,
            'time_in' => '06:45:00',
            'time_out' => null,
            'status' => 'Hadir',
            'late_duration_minutes' => 0,
            'scanned_by' => $this->piket->id,
        ]);

        // Set departure time in future (23:59)
        Setting::updateOrCreate(['key' => 'time_out_start'], ['value' => '23:59']);

        $response = $this->actingAs($this->piket)->postJson('/api/attendance/scan-out', [
            'nisn' => $this->student->nisn,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'warning',
                'scan_type' => 'out',
                'student_name' => $this->student->name,
                'student_nisn' => $this->student->nisn,
            ]);

        $this->assertStringContainsString('Belum saatnya scan pulang', $response->json('message'));
        $this->assertStringContainsString('23:59', $response->json('message'));

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'date' => $today,
            'time_out' => null,
        ]);
    }

    public function test_student_can_scan_out_when_departure_time_has_arrived(): void
    {
        $today = now()->toDateString();
        $attendance = Attendance::create([
            'student_id' => $this->student->id,
            'date' => $today,
            'time_in' => '06:45:00',
            'time_out' => null,
            'status' => 'Hadir',
            'late_duration_minutes' => 0,
            'scanned_by' => $this->piket->id,
        ]);

        // Set departure time in past (00:00)
        Setting::updateOrCreate(['key' => 'time_out_start'], ['value' => '00:00']);

        $response = $this->actingAs($this->piket)->postJson('/api/attendance/scan-out', [
            'nisn' => $this->student->nisn,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'scan_type' => 'out',
                'student_name' => $this->student->name,
                'student_nisn' => $this->student->nisn,
                'attendance_status' => 'Hadir',
            ]);

        $this->assertNotNull($attendance->fresh()->time_out);
    }

    public function test_student_cannot_scan_out_twice(): void
    {
        $today = now()->toDateString();
        Attendance::create([
            'student_id' => $this->student->id,
            'date' => $today,
            'time_in' => '06:45:00',
            'time_out' => '13:05:00',
            'status' => 'Hadir',
            'late_duration_minutes' => 0,
            'scanned_by' => $this->piket->id,
        ]);

        Setting::updateOrCreate(['key' => 'time_out_start'], ['value' => '00:00']);

        $response = $this->actingAs($this->piket)->postJson('/api/attendance/scan-out', [
            'nisn' => $this->student->nisn,
        ]);

        $response->assertStatus(409)
            ->assertJson([
                'status' => 'error',
            ]);

        $this->assertStringContainsString('sudah melakukan scan pulang', $response->json('message'));
    }

    public function test_admin_settings_update_dynamically_changes_departure_time(): void
    {
        $today = now()->toDateString();
        Attendance::create([
            'student_id' => $this->student->id,
            'date' => $today,
            'time_in' => '06:45:00',
            'time_out' => null,
            'status' => 'Hadir',
            'late_duration_minutes' => 0,
            'scanned_by' => $this->piket->id,
        ]);

        // Admin changes time_out_start to 23:30 (future)
        $this->actingAs($this->admin)->put('/admin/settings', [
            'app_name' => 'N-Presence',
            'school_name' => 'SMP Test',
            'time_in_limit' => '07:00',
            'time_in_tolerance' => '07:15',
            'time_out_start' => '23:30',
        ]);

        $this->assertEquals('23:30', Setting::get('time_out_start'));

        // Scan out should be blocked because current time is before 23:30
        $response = $this->actingAs($this->piket)->postJson('/api/attendance/scan-out', [
            'nisn' => $this->student->nisn,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'warning',
            ]);

        // Admin changes time_out_start to 01:00 (past)
        $this->actingAs($this->admin)->put('/admin/settings', [
            'app_name' => 'N-Presence',
            'school_name' => 'SMP Test',
            'time_in_limit' => '07:00',
            'time_in_tolerance' => '07:15',
            'time_out_start' => '01:00',
        ]);

        $this->assertEquals('01:00', Setting::get('time_out_start'));

        // Scan out should now succeed immediately
        $response2 = $this->actingAs($this->piket)->postJson('/api/attendance/scan-out', [
            'nisn' => $this->student->nisn,
        ]);
        $response2->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);
    }
}
