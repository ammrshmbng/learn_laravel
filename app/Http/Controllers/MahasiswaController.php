<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function all()
    {
        // Ambil semua isi tabel mahasiswas menggunakan eloquent
        $mahasiswas = DB::select('SELECT * FROM mahasiswas');
        foreach ($mahasiswas as $mahasiswa) {
          echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }

    public function gabung1()
    {
        // Ambil semua isi tabel mahasiswas dan nilais menggunakan raw query
        $mahasiswas = DB::select('SELECT * FROM mahasiswas, nilais WHERE
                      mahasiswas.id = nilais.mahasiswa_id');
        dump($mahasiswas);
    }

    public function gabung2()
    {
        // Ambil semua isi tabel mahasiswas dan nilais menggunakan raw query
        $mahasiswas = DB::select('SELECT * FROM mahasiswas, nilais WHERE
                      mahasiswas.id = nilais.mahasiswa_id');
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function gabungJoin1()
    {
        // Ambil semua isi tabel mahasiswas dan nilais menggunakan raw query JOIN
        $mahasiswas = DB::select('SELECT * FROM mahasiswas JOIN nilais ON
                      mahasiswas.id = nilais.mahasiswa_id');
        // dd($mahasiswas);
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function gabungJoin2()
    {
        // Ambil 1 data mahasiswa dari kedua tabel
        $mahasiswas = DB::select('SELECT * FROM mahasiswas JOIN nilais ON
        mahasiswas.id = nilais.mahasiswa_id WHERE jurusan = "Ilmu Komputer"');
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function gabungJoin3()
    {
        // Ambil semua isi tabel nilais dan mahasiswas untuk mahasiswa dengan nilai semester 2 lebih dari 3
        $mahasiswas = DB::select('SELECT * FROM mahasiswas JOIN nilais ON
                      mahasiswas.id = nilais.mahasiswa_id WHERE nilais.sem_2 > 3');

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <hr> ";
        }
    }



    //=========================
    //  Eloquent, Mahasiswa Has One Nilai
    //=========================


    public function find()
    {
        // Ambil data mahasiswa dengan id 1
        $mahasiswa = Mahasiswa::find(1);
        dump($mahasiswa);

        // Ambil data mahasiswa dengan id 1, lalu akses nilai
        // $mahasiswa = Mahasiswa::find(1);
        // dump($mahasiswa->nilai);

        // Ambil data mahasiswa dengan id 3, akses nilai, dan tampilkan sebagai array
        // $mahasiswa = Mahasiswa::find(3);
        // dump($mahasiswa->toArray());
        // dump($mahasiswa->nilai->toArray());

        // Ambil data mahasiswa dengan id 3 dan tampilkan data satu per satu
        // $mahasiswa = Mahasiswa::find(3);
        // echo $mahasiswa->nim."<br>";
        // echo $mahasiswa->nama."<br>";
        // echo $mahasiswa->jurusan."<br>";
        // echo $mahasiswa->nilai->sem_1."<br>";
        // echo $mahasiswa->nilai->sem_2."<br>";
        // echo $mahasiswa->nilai->sem_3."<br>";

        // Ambil data mahasiswa dengan id 3 dan tampilkan data dalam 1 baris
        // $mahasiswa = Mahasiswa::find(3);
        // echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        // echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
        // echo "{$mahasiswa->nilai->sem_3}";

        // Harus menggunakan tanda kurung kurawal, kalau tidak akan terjadi efek variable interpolation
        // $mahasiswa = Mahasiswa::find(3);
        // echo $mahasiswa->nilai->sem_1;       echo "<hr>";
        // echo "$mahasiswa->nilai->sem_1";     echo "<hr>";
        // echo "{$mahasiswa->nilai->sem_1}";   echo "<hr>";
    }

    public function where()
    {
        // Tampilkan semua data mahasiswa dengan pencarian nama
        $mahasiswa = Mahasiswa::where('nama','Hesti Ramadan')->first();

        echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        echo "{$mahasiswa->nilai->sem_1}, | {$mahasiswa->nilai->sem_2} | ";
        echo "{$mahasiswa->nilai->sem_3}";
    }

    public function whereChaining()
    {
        // Bisa langsung di chaining
        // Tampilkan nilai semester 2 dari mahasiswa dengan nama Queen Suryatmi
        $nilai = Mahasiswa::where('nama','Queen Suryatmi')->first()->nilai->sem_2;
        echo $nilai;  // 2.98
    }


    public function allJoin()
    {
        // Tampilkan semua nilai yang ada di kedua tabel
        // Error karena ada isi tabel nilais yang tidak berisi
        // $mahasiswas = Mahasiswa::all();
        // foreach ($mahasiswas as $mahasiswa) {
        //     echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        //     echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
        //     echo "{$mahasiswa->nilai->sem_3} <hr>";
        // }

        // Alternatif agar tidak error
        // $mahasiswas = Mahasiswa::all();
        // foreach ($mahasiswas as $mahasiswa) {
        //     echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        //     echo $mahasiswa->nilai->sem_1 ?? 'N/A'; echo " | ";
        //     echo $mahasiswa->nilai->sem_2 ?? 'N/A'; echo " | ";
        //     echo $mahasiswa->nilai->sem_3 ?? 'N/A'; echo " | ";
        //     echo "<br>";
        // }

        // Teknik Eager Loading dengan with()
        $mahasiswas = Mahasiswa::with('nilai')->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo $mahasiswa->nilai->sem_1 ?? 'N/A'; echo " | ";
            echo $mahasiswa->nilai->sem_2 ?? 'N/A'; echo " | ";
            echo $mahasiswa->nilai->sem_3 ?? 'N/A'; echo " | ";
            echo "<br>";
        }
    }


    public function has()
    {
        // Tampilkan semua mahasiswa yang sudah memiliki data di tabel nilai
        // $mahasiswas = Mahasiswa::has('nilai')->get();
        // foreach ($mahasiswas as $mahasiswa) {
        //     echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        //     echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
        //     echo "{$mahasiswa->nilai->sem_3} <br>";
        // }

        // Versi eager loading
        $mahasiswas = Mahasiswa::with('nilai')->has('nilai')->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
            echo "{$mahasiswa->nilai->sem_3} <br>";
        }
    }


    public function whereHas()
    {
        // Tampilkan data mahasiswa yang memiliki IP semester 1 diatas 3
        // $mahasiswas = Mahasiswa::whereHas('nilai', function ($query) {
        //     $query->where('sem_1', '>=', 3);
        // })->get();

        // foreach ($mahasiswas as $mahasiswa) {
        //     echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        //     echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
        //     echo "{$mahasiswa->nilai->sem_3} <br>";
        // }

        // Versi eager loading
        $mahasiswas = Mahasiswa::with('nilai')->whereHas('nilai', function ($query) {
            $query->where('sem_1', '>=', 3);
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
            echo "{$mahasiswa->nilai->sem_3} <br>";
        }
    }

    public function doesntHave()
    {
        // Tampilkan mahasiswa yang tidak memiliki nilai
        $mahasiswas = Mahasiswa::doesntHave('nilai')->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
        }

    }

    public function whereDoesntHave()
    {
        // Tampilkan mahasiswa yang tidak memiliki nilai dan nilai semester 1 tidak lebih dari 3
        $mahasiswas = Mahasiswa::whereDoesntHave('nilai', function ($query) {
            $query->where('sem_1', '>=', 3);
          })->get();

          foreach ($mahasiswas as $mahasiswa) {
              echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
          }
    }

    public function insertSave()
    {
        // Penambahan data ke kedua tabel, cara 1 pakai method save()
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = '19005011';
        $mahasiswa->nama = 'Riana Putria';
        $mahasiswa->jurusan = 'Ilmu Komputer';
        $mahasiswa->save();

        $nilai = new \App\Models\Nilai;
        $nilai->sem_1 = 3.12;
        $nilai->sem_2 = 3.23;
        $nilai->sem_3 = 3.34;

        $mahasiswa->nilai()->save($nilai);
        echo "Penambahan $mahasiswa->nama ke database berhasil";
    }


    public function insertCreate()
    {
        // Penambahan data ke kedua tabel, cara 2 pakai method create()
        // Ini mengggunakan Mass Asignment, jadi tambahkan protected $guarded = []; ke model Mahasiswa dan Nilai
        $mahasiswa = Mahasiswa::create(
          [
            'nim' => '19021044',
            'nama' => 'Rudi Permana',
            'jurusan' => 'Teknik Informatika',
          ]
        );

        $mahasiswa->nilai()->create([
          'sem_1' => 2.19,
          'sem_2' => 2.68,
          'sem_3' => 3.07,
        ]);

        echo "Penambahan $mahasiswa->nama ke database berhasil";
    }

    public function update()
    {
        // Teknik mass assignment
        $mahasiswa = Mahasiswa::find(2);

        $mahasiswa->nilai()->update ([
            'sem_1' => 3.99,
            'sem_2' => 3.88,
            'sem_3' => 3.77,
        ]);

        echo "Data $mahasiswa->nama berhasil di update";
    }

    public function updatePush()
    {
        // Menggunakan method push
        $mahasiswa = Mahasiswa::find(9);

        $mahasiswa->nilai->sem_1 = 2.44;
        $mahasiswa->nilai->sem_2 = 2.55;
        $mahasiswa->nilai->sem_3 = 2.66;

        $mahasiswa->push();
        echo "Data $mahasiswa->nama berhasil di update";
    }

    public function updatePushWhere()
    {
        // Menggunakan method push dengan pencarian
        $mahasiswa = Mahasiswa::where('nama','Hesti Ramadan')->first();
        $mahasiswa->nilai->sem_1 = 2.44;
        $mahasiswa->nilai->sem_2 = 2.55;
        $mahasiswa->nilai->sem_3 = 2.66;

        $mahasiswa->push();
        echo "Data $mahasiswa->nama berhasil di update";
    }

    public function deleteFind()
    {
        // Ini akan error karena isi kolom di tabel nilais harus kosong terlebih dahulu
        // Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails

        $mahasiswa = Mahasiswa::find(1);
        $mahasiswa->delete();

        // Solusinya, kosongkan dulu data yang ada di tabel nilais

        // $mahasiswa = Mahasiswa::find(1);
        // $mahasiswa->nilai->delete();
        // $mahasiswa->delete();

        // echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteWhere()
    {
        // Bisa juga pakai firstOrFail() agar tampil 404 jika mahasiswa tidak ditemukan
        $mahasiswa = Mahasiswa::where('nama','Ika Puspasari')->firstOrFail();
        $mahasiswa->nilai->delete();
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteIf()
    {
        // Error karena mahasiswa tidak memiliki nilai
        // Call to a member function delete() on null
        // $mahasiswa = Mahasiswa::where('nama','Yuliana Nurdiyanti')->firstOrFail();
        // $mahasiswa->nilai->delete();
        // $mahasiswa->delete();

        // echo "Data $mahasiswa->nama berhasil di hapus";

        // Solusi, cek dulu apakah nilai ada atau tidak sebelum dihapus
        // Ini adalah pembatasan dari foreign key
        $mahasiswa = Mahasiswa::where('nama','Yuliana Nurdiyanti')->firstOrFail();
        if (!empty($mahasiswa->nilai)){
            $mahasiswa->nilai->delete();
        }

        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteCascade()
    {
        // Ini juga akan menghapus isi tabel nilais untuk mahasiswa Hesti Ramadan
        $mahasiswa = Mahasiswa::where('nama','Hesti Ramadan')->firstOrFail();
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus <br>";

        // Mahasiswa Yuliana Nurdiyanti tidak memiliki nilai
        $mahasiswa = Mahasiswa::where('nama','Yuliana Nurdiyanti')->firstOrFail();
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function updateCascade()
    {
        // Cari mahasiswa bernama Galang Maryadi, lalu tukar id-nya menjadi 100
        $mahasiswa = Mahasiswa::where('nama','Galang Maryadi')->firstOrFail();
        $mahasiswa->id = 100;
        $mahasiswa->push();

        echo "Id $mahasiswa->nama berhasil di tukar <br>";
    }
}


