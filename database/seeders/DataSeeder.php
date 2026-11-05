<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'guru']);
        Role::firstOrCreate(['name' => 'siswa']);

        // 2. Buat Admin (Kurikulum) - Anis Khoerun Nisa
        $admin = User::updateOrCreate(
            ['nip' => '199209302012022010'],
            [
                'name' => 'Anis Khoerun Nisa, S.Pd.',
                'email' => 'anis@studentarchive.test',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '6281234567890', // Nomor Dummy Admin
            ]
        );
        $admin->assignRole('admin');

          // 2.b Buat Admin (Kurikulum) - Hudzaifah
        $admin2 = User::updateOrCreate(
            ['nip' => '198902082022211007'],
            [
                'name' => 'Hudzaifah, S.Pd.',
                'email' => 'hudzaifah@studentarchive.test',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '6281234567891', // Dummy No HP
            ]
        );
        $admin2->assignRole('admin');

        // 3. Buat Guru (Wali Kelas) + NIP Asli & No HP
        $guruA = User::updateOrCreate(['nip' => '198812212014022003'], [
            'name' => 'Indah Widiningrum, S.Pd.',
            'email' => 'guru.rpla@studentarchive.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'no_hp' => '6281225632164',
        ]);
        $guruA->assignRole('guru');

        $guruB = User::updateOrCreate(['nip' => '199301272020122006'], [
            'name' => 'Hilma Gustami, S.Pd.',
            'email' => 'guru.rplb@studentarchive.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'no_hp' => '6285729012020',
        ]);
        $guruB->assignRole('guru');

        $guruC = User::updateOrCreate(['nip' => '198406292010012028'], [
            'name' => 'Kurniasari, S.Pd., S.Kom.',
            'email' => 'guru.rplc@studentarchive.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'no_hp' => '6281393332966',
        ]);
        $guruC->assignRole('guru');

        // 4. Buat Kelas
        $rplA = ClassRoom::updateOrCreate(['name' => 'XII RPL A'], ['grade' => 'XII', 'major' => 'RPL', 'teacher_id' => $guruA->id]);
        $rplB = ClassRoom::updateOrCreate(['name' => 'XII RPL B'], ['grade' => 'XII', 'major' => 'RPL', 'teacher_id' => $guruB->id]);
        $rplC = ClassRoom::updateOrCreate(['name' => 'XII RPL C'], ['grade' => 'XII', 'major' => 'RPL', 'teacher_id' => $guruC->id]);

        // 5. DATA SISWA XII RPL A (LENGKAP)
        $siswaRplA = [
            ['nama' => 'Aistia Puspitaningrum', 'nis' => '24054', 'tgl' => '2008-07-03'],
            ['nama' => 'Ajimas Aptanegara', 'nis' => '24055', 'tgl' => '2008-11-20'],
            ['nama' => 'Akbar Putra Wiguna', 'nis' => '24056', 'tgl' => '2008-09-09'],
            ['nama' => 'Akram Asad Aufa', 'nis' => '24057', 'tgl' => '2008-12-18'],
            ['nama' => 'Al Madima Kurnianata Wibowo', 'nis' => '24058', 'tgl' => '2008-07-20'],
            ['nama' => 'Almay Sonhaji', 'nis' => '24059', 'tgl' => '2008-12-02'],
            ['nama' => 'Andaryoko Wisnu Murti', 'nis' => '24060', 'tgl' => '2009-02-26'],
            ['nama' => 'Cahya Firdaus Duta Romadhon', 'nis' => '24061', 'tgl' => '2008-09-08'],
            ['nama' => 'Evan Aziz Arganta', 'nis' => '24062', 'tgl' => '2009-01-19'],
            ['nama' => 'Fajar Noval Aldiano', 'nis' => '24063', 'tgl' => '2009-11-25'],
            ['nama' => 'Farhan Fadhilah Kurnia Kamil', 'nis' => '24064', 'tgl' => '2008-10-14'],
            ['nama' => 'Farros Shiddiq Al Fatih', 'nis' => '24065', 'tgl' => '2008-11-24'],
            ['nama' => 'Favian Alifka Hantoro', 'nis' => '24066', 'tgl' => '2009-04-16'],
            ['nama' => 'Jeni Aulia Kusumawati', 'nis' => '24068', 'tgl' => '2009-01-04'],
            ['nama' => 'Keigo Avrel Purnomo', 'nis' => '24069', 'tgl' => '2009-04-19'],
            ['nama' => 'Latifa Nur Alifiyanti', 'nis' => '24070', 'tgl' => '2009-01-30'],
            ['nama' => 'Liliana Puspitasari', 'nis' => '24071', 'tgl' => '2009-04-24'],
            ['nama' => 'Miftah Syarif Islamuddin', 'nis' => '24072', 'tgl' => '2009-05-06'],
            ['nama' => 'Muhammad Arfian Purnama', 'nis' => '24073', 'tgl' => '2009-10-19'],
            ['nama' => 'Muhammad Fadhil Musyaffa', 'nis' => '24074', 'tgl' => '2007-06-10'],
            ['nama' => 'Muhammad Ridwan Arrosyid', 'nis' => '24075', 'tgl' => '2009-03-05'],
            ['nama' => 'Muhyiddin Wildan', 'nis' => '24076', 'tgl' => '2009-12-10'],
            ['nama' => 'Nabil Miftahul Aulia Razan', 'nis' => '24077', 'tgl' => '2008-10-13'],
            ['nama' => 'Nawfal Ahlan Rehma', 'nis' => '24078', 'tgl' => '2009-07-01'],
            ['nama' => 'Nasyilla Yurin Wisena', 'nis' => '24079', 'tgl' => '2008-05-10'],
            ['nama' => 'Rafif Zhafran Atoa Koen', 'nis' => '24080', 'tgl' => '2009-08-19'],
            ['nama' => 'Rafka Nezar Azriel Ghibran', 'nis' => '24081', 'tgl' => '2009-04-16'],
            ['nama' => 'Ramadhan Putra Wijaya', 'nis' => '24082', 'tgl' => '2008-12-09'],
            ['nama' => 'Rayvand Kusuma Ramadhan', 'nis' => '24083', 'tgl' => '2008-08-08'],
            ['nama' => 'Ridwan Al Bari', 'nis' => '24084', 'tgl' => '2009-02-23'],
            ['nama' => 'Tasyakur Rohimah Azzahra', 'nis' => '24085', 'tgl' => '2009-04-27'],
            ['nama' => 'Yahya Hazkia', 'nis' => '24086', 'tgl' => '2009-06-06'],
            ['nama' => 'Zidan Pradana Kusuma', 'nis' => '24087', 'tgl' => '2008-12-06'],
        ];

        foreach ($siswaRplA as $data) {
            $user = User::updateOrCreate(
                ['nis' => $data['nis']],
                [
                    'name' => $data['nama'],
                    'email' => null,
                    'password' => Hash::make('password'),
                    'nip' => $data['tgl'],
                    'no_hp' => null,
                    'role' => 'siswa',
                    'class_id' => $rplA->id,
                ]
            );
            $user->assignRole('siswa');
        }

        // 6. DATA SISWA XII RPL B (LENGKAP)
        $siswaRplB = [
            ['nama' => 'Abror Abiyyi', 'nis' => '24088', 'tgl' => '2008-01-01'],
            ['nama' => 'Al Banie Setyawan', 'nis' => '24089', 'tgl' => '2009-01-16'],
            ['nama' => 'Aldejan Kovic Putra Sulash', 'nis' => '24090', 'tgl' => '2008-09-24'],
            ['nama' => 'Aldo Felicia Pratama', 'nis' => '24091', 'tgl' => '2008-08-28'],
            ['nama' => 'Alfiko Dafa Arfansyah', 'nis' => '24092', 'tgl' => '2008-07-22'],
            ['nama' => 'Aliimna Afilla Prima', 'nis' => '24093', 'tgl' => '2009-05-08'],
            ['nama' => 'Andreas Dwi Prakasa', 'nis' => '24094', 'tgl' => '2008-12-12'],
            ['nama' => 'Anshar Deas Alif Dzulhijah', 'nis' => '24095', 'tgl' => '2007-12-16'],
            ['nama' => 'Ardelia Anggun Saputri', 'nis' => '24096', 'tgl' => '2009-04-11'],
            ['nama' => 'Arfath Yoan Ndaru', 'nis' => '24097', 'tgl' => '2009-05-27'],
            ['nama' => 'Aurel Khaira Lubna Sutrisno', 'nis' => '24099', 'tgl' => '2010-01-21'],
            ['nama' => 'Bagoes Vernanda', 'nis' => '24100', 'tgl' => '2009-11-29'],
            ['nama' => 'Bimo Nugroho', 'nis' => '24101', 'tgl' => '2009-05-27'],
            ['nama' => 'Dhani Argirawan Widiyatmoko', 'nis' => '24102', 'tgl' => '2008-11-25'],
            ['nama' => 'Fahri Ferdiansyah', 'nis' => '24103', 'tgl' => '2009-01-28'],
            ['nama' => 'Ibra Al Tabian', 'nis' => '24105', 'tgl' => '2008-12-14'],
            ['nama' => 'Khansa Khairunnisa', 'nis' => '24106', 'tgl' => '2009-10-19'],
            ['nama' => 'Khansa Qurratu\'ain', 'nis' => '24107', 'tgl' => '2009-10-03'],
            ['nama' => 'Marisa Aprilia Hapsari', 'nis' => '24108', 'tgl' => '2009-04-14'],
            ['nama' => 'Muammar Akvas', 'nis' => '24109', 'tgl' => '2009-05-04'],
            ['nama' => 'Muchammad Naufal Fariz', 'nis' => '24110', 'tgl' => '2009-10-15'],
            ['nama' => 'Muhammad Finza Muta\'ali', 'nis' => '24111', 'tgl' => '2008-08-25'],
            ['nama' => 'Naufal Zaidan Aufaa Chandra', 'nis' => '24112', 'tgl' => '2009-01-24'],
            ['nama' => 'Noufal Rozzak Abizard', 'nis' => '24113', 'tgl' => '2007-08-09'],
            ['nama' => 'Rafif Bari Muzhaffar', 'nis' => '24114', 'tgl' => '2009-12-12'],
            ['nama' => 'Rasheesa Shareef Ahmadi', 'nis' => '24116', 'tgl' => '2009-02-28'],
            ['nama' => 'Rosyidah Alif Hakimah', 'nis' => '24117', 'tgl' => '2008-12-14'],
            ['nama' => 'Salman Alfarizi Bashen', 'nis' => '24118', 'tgl' => '2008-11-25'],
            ['nama' => 'Tsabitah Qurrata A\'yun', 'nis' => '24119', 'tgl' => '2008-09-08'],
            ['nama' => 'Venska Felicia Pertiwi', 'nis' => '24120', 'tgl' => '2009-06-06'],
            ['nama' => 'Yuri Aulia Widyadana', 'nis' => '24121', 'tgl' => '2009-03-19'],
        ];

        foreach ($siswaRplB as $data) {
            $user = User::updateOrCreate(
                ['nis' => $data['nis']],
                [
                    'name' => $data['nama'],
                    'email' => null,
                    'password' => Hash::make('password'),
                    'nip' => $data['tgl'],
                    'no_hp' => null,
                    'role' => 'siswa',
                    'class_id' => $rplB->id,
                ]
            );
            $user->assignRole('siswa');
        }

        // 7. DATA SISWA XII RPL C (LENGKAP)
        $siswaRplC = [
            ['nama' => 'Abdul Aziz Nurrahman', 'nis' => '24122', 'tgl' => '2008-08-12'],
            ['nama' => 'Adiputra Arya Sena', 'nis' => '24123', 'tgl' => '2009-02-09'],
            ['nama' => 'Alvin Younry Putra Mentari', 'nis' => '24124', 'tgl' => '2008-06-30'],
            ['nama' => 'Amadeo Brian Ranastya Putra', 'nis' => '24125', 'tgl' => '2008-07-04'],
            ['nama' => 'Andreas Kelvin Anasta Putra', 'nis' => '24127', 'tgl' => '2009-01-23'],
            ['nama' => 'Anjeli Afifah Darajati', 'nis' => '24128', 'tgl' => '2008-12-07'],
            ['nama' => 'Azriel Aida Nurochim', 'nis' => '24129', 'tgl' => '2009-07-23'],
            ['nama' => 'Bintang Fahri Hascarya', 'nis' => '24130', 'tgl' => '2008-12-22'],
            ['nama' => 'Carisha Amira Insani', 'nis' => '24131', 'tgl' => '2008-10-26'],
            ['nama' => 'Chelsea Muhammad Adli', 'nis' => '24132', 'tgl' => '2009-07-23'],
            ['nama' => 'Christian Wardana', 'nis' => '24133', 'tgl' => '2009-05-06'],
            ['nama' => 'Cleodora Bertha Fortuna', 'nis' => '24134', 'tgl' => '2009-06-27'],
            ['nama' => 'Cristiano Vieli Kaligis', 'nis' => '24135', 'tgl' => '2009-09-30'],
            ['nama' => 'Daffa Farh Irfanuddin', 'nis' => '24136', 'tgl' => '2009-01-24'],
            ['nama' => 'Desta Tiar Redriana', 'nis' => '24137', 'tgl' => '2008-12-18'],
            ['nama' => 'Farrel Brilliant Nugroho', 'nis' => '24138', 'tgl' => '2009-06-04'],
            ['nama' => 'Fida Qurottu Aini', 'nis' => '24139', 'tgl' => '2008-12-13'],
            ['nama' => 'Ghozi Mumtaza Hanif', 'nis' => '24140', 'tgl' => '2009-04-02'],
            ['nama' => 'Irfan Aji Wardana', 'nis' => '24141', 'tgl' => '2008-01-04'],
            ['nama' => 'Manestiko Banyubiru', 'nis' => '24142', 'tgl' => '2009-08-12'],
            ['nama' => 'Michael Aditya', 'nis' => '24144', 'tgl' => '2008-12-02'],
            ['nama' => 'Moses Adi Saputra', 'nis' => '24145', 'tgl' => '2009-10-10'],
            ['nama' => 'Muhammad Anshori', 'nis' => '24146', 'tgl' => '2009-05-14'],
            ['nama' => 'Muhammad Fahri Rahman Arrafi', 'nis' => '24147', 'tgl' => '2009-02-04'],
            ['nama' => 'Muhammad Rosyid Muryanto', 'nis' => '24148', 'tgl' => '2009-03-20'],
            ['nama' => 'Nicholas Gusti Saputra', 'nis' => '24149', 'tgl' => '2009-08-19'],
            ['nama' => 'Pranaja Abi Praya Widyatamaka', 'nis' => '24150', 'tgl' => '2009-03-02'],
            ['nama' => 'Ramaditya Surya Putra', 'nis' => '24151', 'tgl' => '2009-04-30'],
            ['nama' => 'Sabian Apta Arira', 'nis' => '24152', 'tgl' => '2008-07-04'],
            ['nama' => 'Satria Rahmansyah', 'nis' => '24153', 'tgl' => '2009-01-27'],
            ['nama' => 'Theodorick Bakuh Panggalih', 'nis' => '24154', 'tgl' => '2009-05-27'],
            ['nama' => 'X-lan Adi Nugroho', 'nis' => '24155', 'tgl' => '2008-04-23'],
        ];

        foreach ($siswaRplC as $data) {
            $user = User::updateOrCreate(
                ['nis' => $data['nis']],
                [
                    'name' => $data['nama'],
                    'email' => null,
                    'password' => Hash::make('password'),
                    'nip' => $data['tgl'],
                    'no_hp' => null,
                    'role' => 'siswa',
                    'class_id' => $rplC->id,
                ]
            );
            $user->assignRole('siswa');
        }

        // 8. Jenis Dokumen Wajib
        $types = [
            ['name' => 'Raport Semester 1', 'code' => 'raport1', 'is_required' => true],
            ['name' => 'Raport Semester 2', 'code' => 'raport2', 'is_required' => true],
            ['name' => 'Raport Semester 3', 'code' => 'raport3', 'is_required' => true],
            ['name' => 'Raport Semester 4', 'code' => 'raport4', 'is_required' => true],
            ['name' => 'Raport Semester 5', 'code' => 'raport5', 'is_required' => true],
            ['name' => 'Raport Semester 6', 'code' => 'raport6', 'is_required' => true],
            ['name' => 'Sertifikat TOEIC', 'code' => 'toeic', 'is_required' => true],
            ['name' => 'Sertifikat TKA', 'code' => 'tka', 'is_required' => true],
            ['name' => 'Sertifikat UKK', 'code' => 'ukk', 'is_required' => true],
            ['name' => 'Sertifikat PKL', 'code' => 'pkl', 'is_required' => true],
            ['name' => 'Ijazah', 'code' => 'ijazah', 'is_required' => true],
        ];
        
        DocumentType::query()->delete(); 
        foreach ($types as $t) {
            DocumentType::create($t);
        }
    }
}