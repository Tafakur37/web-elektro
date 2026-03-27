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
            'name' => 'KAPRODI',
            'identifier' => 'KAPRODI',
            'email' => 'kaprodi@gmail.com',
            'password' => Hash::make('87654321'),
            'role' => 'kaprodi',
        ]);

// Admin test account (created by admin simulation)
        User::create([
            'name' => 'ADMIN',
            'identifier' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
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

        // Run new seeders (only if users exist)
        if (User::where('identifier', 'ADMIN')->exists()) {
            $this->call([
                JadwalSeeder::class,
                PengumumanSeeder::class,
            ]);
        }
    }
}


