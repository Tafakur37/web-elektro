<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKuliah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'semester' => 1,
                'mata_kuliah' => 'Pemrograman Dasar',
                'dosen' => 'Dr. Ir. John Doe',
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '10:00:00',
                'ruang' => 'E-201',
                'cohort' => null, // All
            ],
            [
                'semester' => 1,
                'mata_kuliah' => 'Fisika Dasar I',
                'dosen' => 'Prof. Jane Smith',
                'hari' => 'Selasa',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'ruang' => 'E-205',
                'cohort' => null,
            ],
            [
                'semester' => 3,
                'mata_kuliah' => 'Sistem Tenaga Listrik',
                'dosen' => 'Ir. Budi Santoso',
                'hari' => 'Rabu',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'ruang' => 'Lab Tenaga',
                'cohort' => 3, // Cohort 3 only
            ],
        ];

        foreach ($samples as $data) {
            JadwalKuliah::create($data);
        }
    }
}
