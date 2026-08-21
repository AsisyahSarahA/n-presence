<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\PermitRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class RealDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Kosongkan semua data lama terlebih dahulu agar database bersih
        Schema::disableForeignKeyConstraints();
        PermitRequest::truncate();
        Attendance::truncate();
        Student::truncate();
        ClassRoom::truncate();
        AcademicYear::truncate();
        Schema::enableForeignKeyConstraints();

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

        // 2. Buat Rombel / Kelas (VII A-C, VIII A-C, IX A-C) beserta Wali Kelas
        $classesData = [
            'VII A'  => 'Popi Sri Anjani',
            'VII B'  => 'SRI WAHYUNI INSAN',
            'VII C'  => 'MIA ROSMIATI',
            'VIII A' => 'EVA SUSANTI',
            'VIII B' => 'IRFAN AGIFARI',
            'VIII C' => 'DINI ERMAWATI',
            'IX A'   => 'DEDE IWAN NURMAWAN',
            'IX B'   => 'EUIS NIA NUGRAHA',
            'IX C'   => 'JUATUN MAHRITA',
        ];

        $classMap = [];
        foreach ($classesData as $className => $teacher) {
            $classMap[$className] = ClassRoom::updateOrCreate(
                ['name' => $className, 'academic_year_id' => $academicYear->id],
                ['homeroom_teacher' => $teacher]
            );
        }

        // 3. Data Siswa Asli Lengkap per Kelas
        $allStudentsData = [
            // --- KELAS VII A ---
            ['class' => 'VII A', 'nisn' => '262707001', 'name' => 'AFIFA NURZAHRA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707042', 'name' => 'AIDAH', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707066', 'name' => 'ALFINO PRASETIA', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707004', 'name' => 'ALIP RIYANA', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707005', 'name' => 'ANDHIKA JANUAR PRATAMA', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707030', 'name' => 'ARIP RAHMATILAH', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707045', 'name' => 'AULIA NUR ALIFA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707007', 'name' => 'CAHYA NUR PUTRA', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707046', 'name' => 'DANI', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707075', 'name' => 'DESI PURWATI', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707009', 'name' => 'DILA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707032', 'name' => 'DIRA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707012', 'name' => 'FIRLI KURNIADI', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707034', 'name' => 'IRNA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707050', 'name' => 'JAKI', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707068', 'name' => 'KINARA MARYAM DZULHIJAH', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707035', 'name' => 'LALAN', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707070', 'name' => 'MAULANA YUSUF', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707053', 'name' => 'METI KHAIRUNISA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707054', 'name' => 'MITA KHAIRUNISA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707036', 'name' => 'RAFFI MUHAMMAD AKBAR', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707037', 'name' => 'RANGGA', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707057', 'name' => 'RANISA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707077', 'name' => 'REGINA SYAPUTRI', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707019', 'name' => 'RESTU IZHARUL HAQ', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707080', 'name' => 'RIZKI SUTIAWAN', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707025', 'name' => 'SUSAN NUR\'AINI', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707071', 'name' => 'SYAHILA DINATA', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707062', 'name' => 'TIRA MULYANI', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707073', 'name' => 'WILDAN NURDIANSYAH', 'gender' => 'L'],
            ['class' => 'VII A', 'nisn' => '262707028', 'name' => 'WITA APRIYANI', 'gender' => 'P'],
            ['class' => 'VII A', 'nisn' => '262707041', 'name' => 'ZIDHAN MUKHOLIDIN', 'gender' => 'L'],

            // --- KELAS VII B ---
            ['class' => 'VII B', 'nisn' => '262707065', 'name' => 'ADELIA AGUSTIYANI', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707078', 'name' => 'ALEGRA QUINERA NUGROHO', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707044', 'name' => 'ARIEF RAHMAN', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707067', 'name' => 'BILQISTI ANGGRAENI', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707074', 'name' => 'CUCU KUSNADI', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707011', 'name' => 'FARID NUR ALIM', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707013', 'name' => 'HADIS NUR ALAMSYAH', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707033', 'name' => 'IMAS SAPITRI', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707014', 'name' => 'JULIA PITRIYANI', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707069', 'name' => 'LIVIA AIRA', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707076', 'name' => 'NAJIB AHSAN KAMIL', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707015', 'name' => 'NATA GUMILAR', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707055', 'name' => 'NINO', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707056', 'name' => 'RAMJI', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707059', 'name' => 'REZA SAPUTRA', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707021', 'name' => 'RIKI MAULANA', 'gender' => 'L'],
            ['class' => 'VII B', 'nisn' => '262707038', 'name' => 'RISMA MEYLA AYU', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707022', 'name' => 'SAKILA RAHMA', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707039', 'name' => 'SALSA FITRI NURAQILA', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707023', 'name' => 'SHYFA AULIA SALSABILA', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707024', 'name' => 'SITI AMINAH', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707040', 'name' => 'TIKA', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707072', 'name' => 'VIKA GUSTIANI', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707027', 'name' => 'WIDYA DARMA AYU', 'gender' => 'P'],
            ['class' => 'VII B', 'nisn' => '262707063', 'name' => 'WINDI ARDIANSYAH', 'gender' => 'L'],

            // --- KELAS VII C ---
            ['class' => 'VII C', 'nisn' => '262707002', 'name' => 'AGUS KURNIAWAN', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707003', 'name' => 'ALIF NURJAMAN', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707043', 'name' => 'ALVYAN RAMDAN', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707006', 'name' => 'ANDIKA PURNAMA', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707008', 'name' => 'DEANDRA HANIA SYAKIRA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707031', 'name' => 'DEVINA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707047', 'name' => 'DIAS', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707048', 'name' => 'DILLA DWI PUTRI LESMANA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707010', 'name' => 'DONI MUHAMAD RAJAB', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707049', 'name' => 'IRMA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707079', 'name' => 'LINA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707051', 'name' => 'MEISYA AMALINA AZZAHRA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707052', 'name' => 'MEISYI AMALINA AISYAH', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707016', 'name' => 'RAFA FEBRIAN', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707017', 'name' => 'RAHMA SYNTIA DEWI', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707058', 'name' => 'RENA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707018', 'name' => 'RENI SEPTIANA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707020', 'name' => 'RIKI HARDIANSYAH', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707060', 'name' => 'SENDI ALFARIZI', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707061', 'name' => 'SUSAN SEPTYANY', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707081', 'name' => 'TEDI', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707026', 'name' => 'TIARA PAUJIYAH AZAHRA', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707082', 'name' => 'WANTI', 'gender' => 'P'],
            ['class' => 'VII C', 'nisn' => '262707064', 'name' => 'YANDI', 'gender' => 'L'],
            ['class' => 'VII C', 'nisn' => '262707029', 'name' => 'ZIDAN SEFTIAN', 'gender' => 'L'],

            // --- KELAS VIII A ---
            ['class' => 'VIII A', 'nisn' => '3136485213', 'name' => 'ADEN BAGJA', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0122878916', 'name' => 'AGUNG GUMELAR', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0124759303', 'name' => 'AJENG DARMA PRATIWI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0124322621', 'name' => 'AKBAR', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0129345598', 'name' => 'ANZAS', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0123285126', 'name' => 'CAHAYA RAISYA', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '3113434029', 'name' => 'DARSA', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0135242196', 'name' => 'DEWI LESTARI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0124032837', 'name' => 'ELIYA', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0134255796', 'name' => 'ERWAN ERWANSAH', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '3133128045', 'name' => 'JESI FEBRIYANTI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0127768530', 'name' => 'KELVIN MUHAMMAD RIZAL', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0122990339', 'name' => 'KURNIAWAN', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0125079298', 'name' => 'MERIAM AGUS TIEN', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0122298007', 'name' => 'NELI ROSIDAH', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0114999198', 'name' => 'PUJI SUGIANTO', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0123357725', 'name' => 'RAFI ARDIANSYAH', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0124376189', 'name' => 'RAHAYU', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0122527243', 'name' => 'RENDIANA', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0135103158', 'name' => 'RETA KORNELI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '3139306274', 'name' => 'REZA NUGRAHA', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0126617464', 'name' => 'RINA NURWINI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0138887819', 'name' => 'RINDIANI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0135223105', 'name' => 'RISMA BELLA', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '3124651162', 'name' => 'RIVANKHA ADITIYA PUTRA', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0125037031', 'name' => 'SELA NURRAHMA', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '3129868248', 'name' => 'SURYA AL AZHAR', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0129317582', 'name' => 'VAHRI AL JABAR', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0129559512', 'name' => 'VERDY DZAKI YURANTO', 'gender' => 'L'],
            ['class' => 'VIII A', 'nisn' => '0139347415', 'name' => 'WIDIYAWATI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0135227772', 'name' => 'WULAN SAPUTRI', 'gender' => 'P'],
            ['class' => 'VIII A', 'nisn' => '0122581013', 'name' => 'YONI', 'gender' => 'L'],

            // --- KELAS VIII B ---
            ['class' => 'VIII B', 'nisn' => '0129268260', 'name' => 'AI HERAWATI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0124758034', 'name' => 'AMIRATUL HIKMAH NURJAMAN', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0119268580', 'name' => 'DAVA', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0126112526', 'name' => 'DIAN RAHADIAN', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0128657920', 'name' => 'FADILLAH SUKMANA', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0124236353', 'name' => 'FARIJAL HANASAR', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0129005125', 'name' => 'HESTI RAHMADANI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0128263408', 'name' => 'IMELIA PEBRIYANTI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0126938466', 'name' => 'ITA', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0123788162', 'name' => 'KAMELIA', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0118695347', 'name' => 'LELY RAHMA', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0128521810', 'name' => 'MOCH RIFKY LUTVIYANSYAH', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0123442482', 'name' => 'MUHAMMAD ALFADILLAH', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0121025280', 'name' => 'MUHAMMAD JAKA', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0127105863', 'name' => 'MUHAMMAD JAKI', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '3136879109', 'name' => 'NABILA ARDELIA YUSUF', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '3137450904', 'name' => 'NASYWA VIDIANTI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0129093604', 'name' => 'NELI WULANDARI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0124304572', 'name' => 'NURAINI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0126897257', 'name' => 'RAINA SITI NUR HAFIZAH', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0129507582', 'name' => 'RIKI', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0128009324', 'name' => 'ROFI RAMDANI', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '3127300301', 'name' => 'SALSABILLA', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0132574665', 'name' => 'SINDI LEANI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '3111124030', 'name' => 'SITI NUR AZIZAH', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '262708083', 'name' => 'SRI MULYANI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0121438336', 'name' => 'TANIA CITRA KANAYA', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0123059584', 'name' => 'TAOPIK HIDAYAT', 'gender' => 'L'],
            ['class' => 'VIII B', 'nisn' => '0129464973', 'name' => 'TASTAP TIYANI', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '262708084', 'name' => 'WIDYA NUR AZIZAH HERMAWANSYAH', 'gender' => 'P'],
            ['class' => 'VIII B', 'nisn' => '0126417132', 'name' => 'ZAMILATUN ANWARIYAH', 'gender' => 'P'],

            // --- KELAS VIII C ---
            ['class' => 'VIII C', 'nisn' => '0129039230', 'name' => 'AA AZA WIDARDJA', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '3138519908', 'name' => 'AHMAD NURHAQIQI', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0123276023', 'name' => 'AI SUSANTI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3127732700', 'name' => 'ANDREAS ALAMSYAH', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '3129695160', 'name' => 'ARMAN RAMADHANI', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0108392929', 'name' => 'BAYU', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0123671146', 'name' => 'CEPI SETIAWAN', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0128115438', 'name' => 'DENA RADIMAN NUGRAHA', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '3138580733', 'name' => 'DITA ANDIANI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '0123489547', 'name' => 'HADIAT', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0121223110', 'name' => 'IBRAHIM AHMAD ZIDAN', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '3134578877', 'name' => 'ICA MAULIDA', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3123836726', 'name' => 'IMAN MUHAMAD RIZKI', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0137705924', 'name' => 'INAYA LARASATI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3136434896', 'name' => 'JAUHARAH HASNA HELMISYAH', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '0121778327', 'name' => 'KHAIRUN NISA', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3128957653', 'name' => 'MUHAMMAD FIRDAN', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '3122519169', 'name' => 'NABILA DAMAYANTI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '0127743694', 'name' => 'NITA HERLINA', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '0127929702', 'name' => 'RISWANDI', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '0113331358', 'name' => 'SAPITRI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '0136014169', 'name' => 'SELPI ANDINI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3132588034', 'name' => 'SELVI SEVTIYANI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3127066805', 'name' => 'SUCI NOVITA SARI', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '0129627654', 'name' => 'SYIFA IRFANI NURALAWIYAH', 'gender' => 'P'],
            ['class' => 'VIII C', 'nisn' => '3123238571', 'name' => 'WANDI', 'gender' => 'L'],
            ['class' => 'VIII C', 'nisn' => '3124477976', 'name' => 'WIDI ARDIA', 'gender' => 'L'],

            // --- KELAS IX A ---
            ['class' => 'IX A', 'nisn' => '0113571248', 'name' => 'AGUNG SUPRIATNA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0124822535', 'name' => 'ALDIAN', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0119325265', 'name' => 'ALIP SAEPULOH', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0117774528', 'name' => 'ANGGUN SUKMA DIANTI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '3129587331', 'name' => 'CANDRA MAULANA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0111399807', 'name' => 'CEPI HERDIANA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '3115200066', 'name' => 'DEBY NURYANI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0126293792', 'name' => 'DEFA MAULANA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0119202016', 'name' => 'DHINI RAMADANI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0112245204', 'name' => 'DINA AULIA PUJIANTI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0127408881', 'name' => 'DINE', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0126467786', 'name' => 'FITRIA JULIANTI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0118644545', 'name' => 'INDRA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0112853863', 'name' => 'LASMANA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0117324909', 'name' => 'LESTRI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0111108885', 'name' => 'LUTHFI ABDUL WAHAB', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0126043436', 'name' => 'LYDIA NURTALITA', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0119272579', 'name' => 'M .AI FARIZI', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0103855145', 'name' => 'NOVA ALFIYATON', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0125285934', 'name' => 'NURHAYATI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '3120889074', 'name' => 'NURI SAFIRA', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0126555779', 'name' => 'OKI SAMSUL ARIPIN', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0114157920', 'name' => 'REIHAN FAHMI', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0109966541', 'name' => 'RENDI RENALDI', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0116945740', 'name' => 'RESTU FIRMANSYAH', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0112706331', 'name' => 'RIDWAN RUSWANA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0115645617', 'name' => 'RIKI RIPANDI', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0116039712', 'name' => 'RIKO RIPANO', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0116367872', 'name' => 'SANDI SOFYANA', 'gender' => 'L'],
            ['class' => 'IX A', 'nisn' => '0113745115', 'name' => 'SELLA RAMADANIA', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '0129924757', 'name' => 'SUSILAWATI', 'gender' => 'P'],
            ['class' => 'IX A', 'nisn' => '3114654016', 'name' => 'WINI SURYANI', 'gender' => 'P'],

            // --- KELAS IX B ---
            ['class' => 'IX B', 'nisn' => '0119966198', 'name' => 'ALFI NUGRAHA', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0122684659', 'name' => 'AURA PEBRILIANI', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0113367517', 'name' => 'CICA AMELIA', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0115917472', 'name' => 'DESI', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0114190586', 'name' => 'DITA', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0128584684', 'name' => 'HERMAWAN', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0118078651', 'name' => 'KEYSHA AMELYA ANGGARA', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0111846773', 'name' => 'M.ARKHA PRATAMA', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0118434328', 'name' => 'MUHAMMAD RASYA AL FICKRIE', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0106294080', 'name' => 'MUHAMMAD RIZAL', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0117528116', 'name' => 'RENDI', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0129168134', 'name' => 'RIFKI RAMDANI', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0114541035', 'name' => 'RINA', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0114038851', 'name' => 'RIRIN SABRINA', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0119678470', 'name' => 'RISKI', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0117637261', 'name' => 'SANDI TAUFIK', 'gender' => 'L'],
            ['class' => 'IX B', 'nisn' => '0112493314', 'name' => 'SELA NABILA PUTRI', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0116273559', 'name' => 'SILVIA DAMAYANTI', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0118824186', 'name' => 'SITI RAHMAWATI', 'gender' => 'P'],
            ['class' => 'IX B', 'nisn' => '0122648559', 'name' => 'VANCY RAFAEL', 'gender' => 'L'],

            // --- KELAS IX C ---
            ['class' => 'IX C', 'nisn' => '0111452888', 'name' => 'ADIT', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0127707328', 'name' => 'ALIF ROHAMTULLOH', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0122500621', 'name' => 'AZIVA NUR VADILA', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0107294675', 'name' => 'BELA SABILA', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0118757409', 'name' => 'DESTA', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0118951673', 'name' => 'DYSTA PUTRA RUSTANDI', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0114621548', 'name' => 'ERNI WULAN SARI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0129690969', 'name' => 'HANDAYANI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0118445737', 'name' => 'JEJE NURJANAH', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0112971502', 'name' => 'KEPIN KAMAL APRIAN', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0113893777', 'name' => 'LISTIANI RISKA ROHMADONI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0118711919', 'name' => 'NUGI NURFALAH', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0119748600', 'name' => 'REPAN', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0127493904', 'name' => 'RESTI SUMIATI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0117252310', 'name' => 'RESTU HARDIANSYAH', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0117701871', 'name' => 'ROSMIYATI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0116348396', 'name' => 'SALMA NOVIANTI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0115818292', 'name' => 'SALMAN ALFARIZI SOLEH', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0116245222', 'name' => 'SANTI SEPTIANI', 'gender' => 'P'],
            ['class' => 'IX C', 'nisn' => '0115289641', 'name' => 'SONA WIRAGA', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0116296626', 'name' => 'WANDA', 'gender' => 'L'],
            ['class' => 'IX C', 'nisn' => '0111539553', 'name' => 'WILDANSYAH', 'gender' => 'L'],
        ];

        $studentModels = [];
        foreach ($allStudentsData as $data) {
            $classObj = $classMap[$data['class']] ?? null;
            if (!$classObj) continue;

            $studentModels[] = Student::updateOrCreate(
                ['nisn' => $data['nisn']],
                [
                    'name' => $data['name'],
                    'class_id' => $classObj->id,
                    'gender' => $data['gender'],
                    'is_active' => true
                ]
            );
        }

        // 4. Generate Absensi Acak untuk Hari Ini (Variasi Hadir dan Terlambat)
        $today = Carbon::today();
        $piketUser = User::where('role', 'piket')->first();
        $piketId = $piketUser ? $piketUser->id : null;

        $statuses = ['Hadir', 'Terlambat'];

        foreach ($studentModels as $student) {
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
                    'time_out' => null,
                    'status' => $status,
                    'late_duration_minutes' => $lateMinutes,
                    'scanned_by' => $piketId,
                    'notes' => $status === 'Terlambat' ? 'Scan masuk terlambat' : 'Hadir tepat waktu'
                ]
            );
        }
    }
}
