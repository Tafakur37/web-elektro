<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Test user (commented out)
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        // Kaprodi test account (created by admin simulation)
        User::create([
            'name' => 'Kaprodi',
            'identifier' => 'kaprodi',
            'email' => 'kaprodi@gmail.com',
            'password' => Hash::make('kaprodi'),
            'role' => 'kaprodi',
        ]);

        // Admin test account (created by admin simulation)
        User::create([
            'name' => 'Superman',
            'identifier' => 'superman',
            'email' => 'superman@gmail.com',
            'password' => Hash::make('orangkuat'),
            'role' => 'admin',
        ]);

        // Dosen test account - dosen_a (login: dosen_a / dosen)
        User::create([
            'name' => 'DOSEN A',
            'identifier' => 'dosen_a',
            'email' => 'dosen_a@gmail.com',
            'password' => Hash::make('dosen'),
            'role' => 'dosen',
        ]);

        // Staff Prodi test account
        User::create([
            'name' => 'Staff Prodi',
            'identifier' => 'staff_prodi',
            'email' => 'staff_prodi@gmail.com',
            'password' => Hash::make('staffprodi'),
            'role' => 'staff_prodi',
        ]);

        // Sesprodi test account
        User::create([
            'name' => 'Sesprodi',
            'identifier' => 'sesprodi',
            'email' => 'sesprodi@gmail.com',
            'password' => Hash::make('sesprodi'),
            'role' => 'sesprodi',
        ]);

        // Run new seeders (only if users exist)
        if (User::where('identifier', 'superman')->exists()) {
            $this->call([
                MatkulSeeder::class,
                JadwalSeeder::class,
                PengumumanSeeder::class,
            ]);
        }
    }
}
?>

