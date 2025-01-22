<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class MatakuliahController extends Controller
{
    public function all()
    {
        // Ambil semua isi tabel matakuliahs menggunakan eloquent
        $matakuliahs = Matakuliah::all();
        foreach ($matakuliahs as $matakuliah) {
            echo "$matakuliah->id | $matakuliah->kode |
                  $matakuliah->nama | $matakuliah->jumlah_sks <br>";
        }
    }

    public function attach()
    {
        // Cari matakuliah dengan id 3
        $matakuliah = Matakuliah::find(3);
        // dd($matakuliah);

        // Cari mahasiswa dengan id 4
        $mahasiswa = Mahasiswa::find(4);
        // dd($mahasiswa);

        // Lakukan proses attach
        $matakuliah->mahasiswas()->attach($mahasiswa);

        echo "Proses attach berhasil";
    }

    public function attachWhere()
    {
        // Cari matakuliah 'Kalkulus Dasar'
        $matakuliah = Matakuliah::where('nama','Kalkulus Dasar')->first();

        // Cari semua mahasiswa dari jurusan Teknik Informatika
        $mahasiswas = Mahasiswa::where('jurusan','Teknik Informatika')->get();

        // Lakukan proses attach
        $matakuliah->mahasiswas()->attach($mahasiswas);

        echo "Proses attach berhasil";
    }


    public function tampil()
    {
        // Cari matakuliah 'Kalkulus Dasar'
        $matakuliah = Matakuliah::where('nama','Kalkulus Dasar')->first();

        // Tampilkan semua mahasiswa yang mengambil mata kuliah Kalkulus Dasar
        echo "## Daftar mahasiswa yang mengambil mata kuliah $matakuliah->nama ## ";
        echo "<hr>";
        foreach ($matakuliah->mahasiswas as $mahasiswa)
        {
            echo "$mahasiswa->nim: $mahasiswa->nama ($mahasiswa->jurusan) <br>";
        }
    }

    public function detach()
    {
        // Cari matakuliah 'Kalkulus Dasar'
        $matakuliah = Matakuliah::where('nama','Kalkulus Dasar')->first();

        // Cari mahasiswa dengan nama 'Galang Maryadi'
        $mahasiswa = Mahasiswa::where('nama','Galang Maryadi')->first();
        // dd($matakuliah);

        // Lakukan proses detach
        $matakuliah->mahasiswas()->detach($mahasiswa);

        echo "Proses detach berhasil";
    }

    public function sync()
    {
        Matakuliah::where('nama','Kalkulus Dasar')->first()->mahasiswas()
        ->sync(Mahasiswa::find([2,3,4]));

        echo "Proses sync berhasil";
    }


    // pivot ini dipakai untuk mengakses kolom created_at di tabel mahasisiswa_matakuliah
    public function pivot()
    {
        // Cari matakuliah 'Kalkulus Dasar'
        $matakuliah = Matakuliah::where('nama','Kalkulus Dasar')->first();

        // Tampilkan semua mahasiswa yang mengambil mata kuliah Kalkulus Dasar
        echo "## Daftar mahasiswa yang mengambil mata kuliah $matakuliah->nama ## ";
        echo "<hr>";
        foreach ($matakuliah->mahasiswas as $mahasiswa)
        {
            echo "$mahasiswa->nama ($mahasiswa->jurusan),
                  mengambil mata kuliah pada
                 {$mahasiswa->pivot->created_at->isoFormat('D MMMM Y')} <br>";
        }
    }
}
