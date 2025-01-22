<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $faker->seed(123);
        $jurusan = ["Ilmu Komputer", "Teknik Informatika", "Sistem Informasi"];

        for ($i=0; $i<10; $i++) {
          Mahasiswa::create(
            [
              'nim' => $faker->unique()->numerify('10######'),
              'nama' => $faker->firstName." ".$faker->lastName,
              'jurusan' => $faker->randomElement($jurusan),
            ]
          );
        }

        Matakuliah::create(
            [
                'kode' => 'AP001',
                'nama' => 'Algoritma dan Pemrograman',
                'jumlah_sks' => 2,
            ]
        );

        Matakuliah::create(
            [
                'kode' => 'AL002',
                'nama' => 'Aljabar Linear',
                'jumlah_sks' => 2,
            ]
        );

        Matakuliah::create(
            [
                'kode' => 'KG001',
                'nama' => 'Kriptografi',
                'jumlah_sks' => 2,
            ]
        );

        Matakuliah::create(
            [
                'kode' => 'KD004',
                'nama' => 'Kalkulus Dasar',
                'jumlah_sks' => 4,
            ]
        );

        Matakuliah::create(
            [
                'kode' => 'PB012',
                'nama' => 'Pemrograman Berorientasi Objek',
                'jumlah_sks' => 3,
            ]
        );

    }
}
