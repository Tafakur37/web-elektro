<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;
use App\Models\User;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        // Use admin or kaprodi ID (assuming 2=admin, 1=kaprodi)
        $adminId = User::where('identifier', 'ADMIN')->first()->id ?? 2;

        $samples = [
            [
                'title' => 'Jadwal Kuliah Tetap Semester Ganjil 2026/2027',
                'content' => 'Perkuliahan berjalan sesuai jadwal. Cek dashboard untuk jadwal lengkap. Materi tersedia di menu Bahan Ajar.',
                'created_by' => $adminId,
                'is_active' => true,
            ],
            [
                'title' => 'Pengumuman UTS',
                'content' => 'Ujian Tengah Semester dilaksanakan minggu ke-8. Persiapkan diri dan koordinasi dengan dosen mata kuliah.',
                'created_by' => $adminId,
                'is_active' => true,
            ],
            [
                'title' => 'Libur Nasional Hari Buruh',
                'content' => 'Tidak ada perkuliahan pada 1 Mei 2026. Kuliah dilanjutkan minggu depan.',
                'created_by' => $adminId,
                'is_active' => true,
            ],
        ];

        foreach ($samples as $data) {
            Pengumuman::create($data);
        }
    }
}
