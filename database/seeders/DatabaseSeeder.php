<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Dea',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Disarankan menggunakan Hash::make() untuk mengenkripsi password
            'role' => 'Admin',
            'jabatan' => 'Administrator',
            'unit' => 'Cicadas Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Ara',
            'email' => 'ara@example.com',
            'password' => Hash::make('password'), // Disarankan menggunakan Hash::make() untuk mengenkripsi password
            'role' => 'Admin',
            'jabatan' => 'Administrator',
            'unit' => 'Cikutra',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Cihapit Admin',
            'email' => 'cihapitadmin@example.com',
            'password' => Hash::make('password'), // Disarankan menggunakan Hash::make() untuk mengenkripsi password
            'role' => 'Admin',
            'jabatan' => 'Administrator',
            'unit' => 'Cihapit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Cihapit User',
            'email' => 'cihapituser@example.com',
            'password' => Hash::make('password'), // Disarankan menggunakan Hash::make() untuk mengenkripsi password
            'role' => 'User',
            'jabatan' => 'Mantri',
            'unit' => 'Cihapit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Hasan',
            'email' => 'hasan@example.com',
            'password' => Hash::make('password'), // Disarankan menggunakan Hash::make() untuk mengenkripsi password
            'role' => 'User',
            'jabatan' => 'Customer Service',
            'unit' => 'Cicadas Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Admin Cabang Bandung',
            'email' => 'admincabang@example.com',
            'password' => Hash::make('password'), // Disarankan menggunakan Hash::make() untuk mengenkripsi password
            'role' => 'Admin Cabang',
            'jabatan' => 'Administrator',
            'unit' => 'Martadinata',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call([
            BerkasSeeder::class,
            UnitSeeder::class
        ]);
    }
}
