<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Mahasiswa;
use App\Models\Nilai;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $faker->seed(123);
        $jurusan = ["Ilmu Komputer", "Teknik Informatika", "Sistem Informasi"];

        for ($i = 0; $i < 10; $i++) {
            Mahasiswa::create(
                [
                    'nim' => $faker->unique()->numerify('10######'),
                    'nama' => $faker->firstName . " " . $faker->lastName,
                    'jurusan' => $faker->randomElement($jurusan),
                ]
            );
        }

        for ($i = 0; $i < 5; $i++) {
            Nilai::create(
                [
                    'sem_1' => $faker->randomFloat(2, 2, 4),
                    'sem_2' => $faker->randomFloat(2, 2, 4),
                    'sem_3' => $faker->randomFloat(2, 2, 4),
                    'mahasiswa_id' => $faker->unique()->randomDigit,
                ]
            );
        }
    }
}
