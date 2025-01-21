<?php

namespace App\Http\Controllers;
use App\Models\Jurusan;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function find()
    {
        // Tampilkan nama jurusan dari mahasiswa yang memiliki id 2
        $mahasiswa = Mahasiswa::find(2);

        echo "$mahasiswa->nama, dari jurusan {$mahasiswa->jurusan->nama}";
    }

    public function where()
    {
        // Cari 1 mahasiswa dengan awalan nama "R", dan diurutkan berdasarkan nama secara menurun
        $mahasiswa = Mahasiswa::where('nama','like','M%')
                     ->orderBy('nama', 'desc')->firstOrFail();

        echo "$mahasiswa->nama, dari jurusan {$mahasiswa->jurusan->nama}";
    }

    public function whereChaining()
    {
        // Tampilkan nama jurusan dari mahasiswa dengan nama 'Rina Kumala Sari'
        echo Mahasiswa::where('nama','Mahdi Rajata')->firstOrFail()->jurusan->nama;
    }

    public function has()
    {
        // Tampilkan semua mahasiswa harus memiliki jurusan, sebenarnya ini akan menampilkan semua mahasiswa
        // karena kolom jurusan_id sebagai foreign key tidak boleh kosong
        $mahasiswas = Mahasiswa::has('jurusan')->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama, ";
        }
    }

    public function whereHas()
    {
        // Tampilkan semua mahasiswa yang memiliki jurusan dan berasal dari jurusan 'Sistem Informasi'
        $mahasiswas = Mahasiswa::whereHas('jurusan', function ($query) {
            $query->where('nama','Sistem Informasi');
        })->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama, ";
        }
    }

    public function doesntHave()
    {
        // Tampilkan semua mahasiswa yang tidak memiliki jurusan, kosong karena memang tidak bisa
        $mahasiswas = Mahasiswa::doesntHave('jurusan')->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo $mahasiswa->nama.", ";
        }
    }

    public function associate()
    {
        // Cari jurusan, simpan object Jurusan. Buat mahasiswa baru, lalu hubungkan dengan jurusan.

        $jurusan = Jurusan::where('nama','Teknik Komputer')->first();

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = '19001516';
        $mahasiswa->nama = 'Christine Wijaya';

        $mahasiswa->jurusan()->associate($jurusan);
        $mahasiswa->save();

        echo "Penambahan $mahasiswa->nama ke database berhasil";
    }


    public function associateUpdate()
    {
        // Cari jurusan, simpan object Jurusan. Cari mahasiswa, lalu hubungkan dengan jurusan.

        $jurusan = Jurusan::where('nama','Ilmu Komputer')->first();
        $mahasiswa = Mahasiswa::where('nama','Christine Wijaya')->first();

        $mahasiswa->jurusan()->associate($jurusan);
        $mahasiswa->save();

        echo "Perubahan jurusan $mahasiswa->nama berhasil";
    }


    public function delete()
    {
        // Cari semua mahasiswa yang berasal dari jurusan Ilmu Komputer, lalu hapus nilainya dari tabel mahasiswa

        $mahasiswas = Mahasiswa::whereHas('jurusan', function ($query) {
            $query->where('nama','Ilmu Komputer');
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            $mahasiswa->delete();
        }

        echo "Semua mahasiswa jurusan Ilmu Komputer berhasil di hapus";
    }

    public function dissociate()
    {

        // Cari mahasiswa yang memiliki jurusan Sistem Informasi, lalu kosongkan kolom jurusan_id

        // Cari semua mahasiswa Sistem Informasi
        $mahasiswas = Mahasiswa::whereHas('jurusan', function ($query) {
            $query->where('nama','Sistem Informasi');
        })->get();

        // dd($mahasiswas->toArray());
        // harus pakai loop karena $mahasiswas berbentuk array dari object mahasiswa
        foreach ($mahasiswas as $mahasiswa) {
            $mahasiswa->jurusan()->dissociate();
            $mahasiswa->save();
            echo "Pengosongan jurusan untuk $mahasiswa->nama berhasil <br>";
        }

        // Integrity constraint violation: 1048 Column 'jurusan_id' cannot be null
        // Secara bawaan ini tidak bisa dilakukan karena foreign key tidak boleh kosong

        // Agar bisa dijalankan, ubah migration untuk kolom jurusan_id menjadi
        // $table->foreignId('jurusan_id')->nullable()->constrained()->onDelete('cascade');
        // Dengan tambahan nullable, maka kolom jurusan_id boleh tidak diisi.
        // Jalankan ulang migration, lalu jalankan lagi URL ini

        // Secara umum, nullable untuk foreign id bukan design yang baik
    }

}
