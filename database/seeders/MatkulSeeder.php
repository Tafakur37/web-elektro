<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matkul;

class MatkulSeeder extends Seeder
{
    public function run(): void
    {
        $matkuls = [
            ['nama_matkul' => 'Pemrograman Dasar', 'kode_matkul' => 'PD01', 'sks' => 3],
            ['nama_matkul' => 'Fisika Dasar I', 'kode_matkul' => 'FD01', 'sks' => 4],
            ['nama_matkul' => 'Rangkaian Listrik I', 'kode_matkul' => 'RL01', 'sks' => 3],
            ['nama_matkul' => 'Sistem Tenaga Listrik', 'kode_matkul' => 'STL01', 'sks' => 3],
            ['nama_matkul' => 'Elektronika Daya', 'kode_matkul' => 'ED01', 'sks' => 3],
            ['nama_matkul' => 'Statistika', 'kode_matkul' => 'ST01', 'sks' => 2],
        ];

        foreach ($matkuls as $matkul) {
            Matkul::create($matkul);
        }
    }
}
?>

