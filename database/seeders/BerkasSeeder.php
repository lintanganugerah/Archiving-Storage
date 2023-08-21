<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berkas;
use App\Models\Agunan;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 500; $i++) {
            $jenis = $faker->randomElement(['Kredit', 'Tabungan', 'Lunas', 'Daftar Hitam']);
            $lemari = ($jenis === 'Kredit' || 'Tabungan') ? chr(rand(65, 87)) : (($jenis === 'Daftar Hitam') ? chr(rand(88, 90)) : 'AA');
            $unit = $faker->randomElement(['0757', '0754', '0751', '3679', '3681', '7006']);
            $berkas = Berkas::create([
                'no_rek' => $unit . $faker->numerify('##########'),
                'nama' => $faker->name,
                'cif' => Str::upper($faker->bothify('????###')),
                'agunan' => ($jenis === 'Kredit' ? $faker->randomElement(['BPKB', 'Surat Tanah']) : '-'),
                'jenis' => $jenis,
                'lokasi' => ($unit === '0757' ? 'Cicadas Barat' : ($unit === '0754' ? 'Cihapit' : ($unit === '0751' ? 'Citamiang' : ($unit === '3679' ? 'Kebonwaru' : ($unit === '3681' ? 'Sadang Serang' : ($unit === '7006' ? 'Cikutra Barat' : '')))))),
                'ruang' => rand(1, 2),
                'lemari' => chr(rand(65, 87)),
                'rak' => rand(1, 4),
                'baris' => rand(1, 60),
            ]);

            // Generate data agunan yang terkait dengan berkas
            if ($jenis === 'Kredit') {
                Agunan::create([
                    'nama' => $berkas->nama,
                    'cif' => $berkas->cif,
                    'agunan' => $berkas->agunan,
                    'lokasi' => $berkas->lokasi,
                    'ruang_agunan' => rand(3, 4),
                    'lemari_agunan' => chr(rand(65, 87)),
                    'rak_agunan' => rand(1, 4),
                    'baris_agunan' => rand(1, 60),
                ]);
            }
        }
    }
}







