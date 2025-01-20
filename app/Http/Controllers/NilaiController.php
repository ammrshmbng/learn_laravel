<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function find()
    {
        // Tampilkan data mahasiswa yang memiliki id 2 dari tabel nilai
        $nilai = Nilai::find(2);

        echo "{$nilai->mahasiswa->nim} | ";
        echo "{$nilai->mahasiswa->nama} | ";
        echo "{$nilai->mahasiswa->jurusan} | ";
        echo "$nilai->sem_1 | $nilai->sem_2 | $nilai->sem_3";
    }

    public function where()
    {
        // Cari 1 mahasiswa dengan nilai semester 3 diatas 2
        $nilai = Nilai::where('sem_3','>',2)->first();

        echo "{$nilai->mahasiswa->nim} | ";
        echo "{$nilai->mahasiswa->nama} | ";
        echo "{$nilai->mahasiswa->jurusan} | ";
        echo "$nilai->sem_1 | $nilai->sem_2 | $nilai->sem_3";
    }

    public function whereChaining()
    {
        // Cari 1 mahasiswa dengan nilai semester 3 diatas 2
        echo Nilai::where('sem_3','>',2)->first()->mahasiswa->nama; // Galang Maryadi
    }

    public function has()
    {
        // Tampilkan semua siswa yang memiliki nilai
        $nilais = Nilai::has('mahasiswa')->get();
        foreach ($nilais as $nilai) {
            echo $nilai->mahasiswa->nama." | ";
        }
    }

    public function hasEager()
    {
        // Tampilkan semua siswa yang memiliki nilai, versi eager loading
        $nilais = Nilai::with('mahasiswa')->has('mahasiswa')->get();
        foreach ($nilais as $nilai) {
            echo $nilai->mahasiswa->nama." | ";
        }
    }


    public function testInput1()
    {
        // Test input nilai tanpa mengisi kolom mahasiswa_id:
        $nilai = new Nilai;
        $nilai->sem_1 = 3.12;
        $nilai->sem_2 = 3.23;
        $nilai->sem_3 = 3.34;
        $nilai->save();

        echo "Penambahan nilai ke database berhasil";
        // SQLSTATE[HY000]: General error: 1364
        // Field 'mahasiswa_id' doesn't have a default value
    }

    public function testInput2()
    {
        // Test input nilai dengan mengisi mahasiswa yang belum ada
        $nilai = new Nilai;
        $nilai->sem_1 = 3.12;
        $nilai->sem_2 = 3.23;
        $nilai->sem_3 = 3.34;
        $nilai->mahasiswa_id = 20;
        $nilai->save();

        echo "Penambahan nilai ke database berhasil";
        // SQLSTATE[23000]: Integrity constraint violation: 1452
        // Cannot add or update a child row: a foreign key constraint fails
    }

    public function testInput3()
    {
        // Test input nilai dengan mengisi mahasiswa yang sudah memiliki nilai sebelumnya
        $nilai = new Nilai;
        $nilai->sem_1 = 3.12;
        $nilai->sem_2 = 3.23;
        $nilai->sem_3 = 3.34;
        $nilai->mahasiswa_id = 3;
        $nilai->save();

        echo "Penambahan nilai ke database berhasil";
        // SQLSTATE[23000]: Integrity constraint violation: 1062
        // Duplicate entry '3' for key 'nilais_mahasiswa_id_unique'
    }

    public function testInput4()
    {
        // Ini bisa karena mahasiswa dengan id 5 sudah ada dan belum memiliki nilai
        $nilai = new Nilai;
        $nilai->sem_1 = 3.12;
        $nilai->sem_2 = 3.23;
        $nilai->sem_3 = 3.34;
        $nilai->mahasiswa_id = 5;
        $nilai->save();

        echo "Penambahan nilai ke database berhasil";
    }

    public function associateNew()
    {
        // Gunakan method associate(), kemudian baru di simpan
        // Ini diperlukan agar tidak perlu melihat dulu id dari mahasiswa.
        // Method associate akan menyamakan nomor id untuk tabel nilai

        $mahasiswa = new \App\Models\Mahasiswa;
        $mahasiswa->nim = '19005011';
        $mahasiswa->nama = 'Riana Putria';
        $mahasiswa->jurusan = 'Ilmu Komputer';
        $mahasiswa->save();

        $nilai = new Nilai;
        $nilai->sem_1 = 3.44;
        $nilai->sem_2 = 3.55;
        $nilai->sem_3 = 3.66;

        $nilai->mahasiswa()->associate($mahasiswa);
        $nilai->save();

        echo "Penambahan $mahasiswa->nama dan nilainya ke database berhasil";
    }


    public function associateFind()
    {
        // Cari mahasiswa dengan id 7, mahasiswa ini harus belum memiliki nilai
        // Hal yang sama juga bisa dilakukan untuk pencarian mahasiswa dengan where()
        // Dimana selama kita memiliki object mahasiswa, maka bisa di associate dengan nilai

        $mahasiswa = \App\Models\Mahasiswa::find(7);

        $nilai = new Nilai;
        $nilai->sem_1 = 3.55;
        $nilai->sem_2 = 3.66;
        $nilai->sem_3 = 3.77;

        $nilai->mahasiswa()->associate($mahasiswa);
        $nilai->save();

        echo "Nilai untuk $mahasiswa->nama sudah ditambahkan ";
    }


    public function delete()
    {
        // Hapus data tabel nilai dengan id 3
        $nilai = Nilai::find(3);
        $nilai->delete();
        echo "Nilai berhasil di hapus";
    }


    public function deleteMahasiswa()
    {
        // Hapus data tabel nilai dengan id 2, lalu hapus juga mahasiswa yang terhubung ke nilai tersebut
        $nilai = Nilai::find(2);
        $nilai->delete();

        $nama_mahasiswa = $nilai->mahasiswa->nama;
        $nilai->mahasiswa()->delete();

        echo "Data $nama_mahasiswa berhasil di hapus (beserta nilainya)";
    }

}
