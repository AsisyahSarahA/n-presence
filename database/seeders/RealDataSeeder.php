<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RealDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Academic Year aktif
        $academicYear = AcademicYear::updateOrCreate(
            ['name' => '2026/2027'],
            [
                'start_date' => '2026-07-01',
                'end_date' => '2027-06-30',
                'is_active' => true
            ]
        );

        // Pastikan tahun ajaran lain non-aktif
        AcademicYear::where('id', '!=', $academicYear->id)->update(['is_active' => false]);

        // 2. Buat Class
        $classRoom = ClassRoom::updateOrCreate(
            ['name' => 'VII A', 'academic_year_id' => $academicYear->id],
            ['homeroom_teacher' => 'Popi Sri Anjani']
        );

        // 3. Masukkan Data Siswa Asli
        $studentsData = [
            ['nisn' => '0131124826', 'name' => 'AFIFA NURZAHRA', 'gender' => 'P'],
            ['nisn' => '0132533991', 'name' => 'AIDAH', 'gender' => 'P'],
            ['nisn' => '0136196196', 'name' => 'ALFINO PRASETIA', 'gender' => 'L'],
            ['nisn' => '0134963127', 'name' => 'ALIP RIYANA', 'gender' => 'L'],
            ['nisn' => '0137006291', 'name' => 'LALAN', 'gender' => 'L'],
            ['nisn' => '3131678311', 'name' => 'METI KHAIRUNISA', 'gender' => 'P'],
            ['nisn' => '3138161137', 'name' => 'RAFFI MUHAMMAD AKBAR', 'gender' => 'L'],
            ['nisn' => '0132065355', 'name' => 'Ranisa Andhara', 'gender' => 'P'],
        ];

        $studentModels = [];
        foreach ($studentsData as $data) {
            $studentModels[] = Student::updateOrCreate(
                ['nisn' => $data['nisn']],
                [
                    'name' => $data['name'],
                    'class_id' => $classRoom->id,
                    'gender' => $data['gender'],
                    'is_active' => true
                ]
            );
        }

        // 4. Generate Absensi Acak untuk Hari Ini (Variasi Hadir dan Terlambat)
        $today = Carbon::today();
        $piketUser = User::where('role', 'piket')->first();
        $piketId = $piketUser ? $piketUser->id : null;

        // Distribusi Status Kehadiran Acak
        $statuses = ['Hadir', 'Terlambat'];

        foreach ($studentModels as $index => $student) {
            // Kita acak statusnya
            $status = $statuses[array_rand($statuses)];
            $timeIn = null;
            $lateMinutes = 0;

            if ($status === 'Hadir') {
                // Tepat waktu: antara 06:30 s.d 07:00
                $hour = 6;
                $minute = rand(30, 59);
                $timeIn = sprintf('%02d:%02d:00', $hour, $minute);
            } else {
                // Terlambat: antara 07:16 s.d 07:45
                $hour = 7;
                $minute = rand(16, 45);
                $timeIn = sprintf('%02d:%02d:00', $hour, $minute);
                
                // Hitung menit telat (Toleransi jam 07:15)
                $limit = Carbon::createFromFormat('H:i:s', '07:15:00');
                $actual = Carbon::createFromFormat('H:i:s', $timeIn);
                $lateMinutes = $actual->diffInMinutes($limit);
            }

            Attendance::updateOrCreate(
                ['student_id' => $student->id, 'date' => $today->toDateString()],
                [
                    'time_in' => $timeIn,
                    'time_out' => '12:05:00', // Waktu pulang default
                    'status' => $status,
                    'late_duration_minutes' => $lateMinutes,
                    'scanned_by' => $piketId,
                    'notes' => $status === 'Terlambat' ? 'Scan masuk terlambat' : 'Hadir tepat waktu'
                ]
            );
        }
    }
}
