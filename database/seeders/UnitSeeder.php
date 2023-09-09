<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'unit' => "Cicadas Barat",
            'kode' => "0757",
        ]);
        Unit::create([
            'unit' => "Cihapit",
            'kode' => "0754",
        ]);
        Unit::create([
            'unit' => "Citamiang",
            'kode' => "0751",
        ]);
        Unit::create([
            'unit' => "Kebonwaru",
            'kode' => "3679",
        ]);
        Unit::create([
            'unit' => "Sadang Serang",
            'kode' => "3681",
        ]);
        Unit::create([
            'unit' => "Cikutra Barat",
            'kode' => "7006",
        ]);
    }
}
