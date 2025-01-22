<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class MahasiswaController extends Controller
{
    public function all()
    {
        // Ambil semua isi tabel mahasiswas menggunakan eloquent
        $mahasiswas = Mahasiswa::all();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->id | $mahasiswa->nim | ";
            echo "$mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }

    public function attach()
    {
        // Cari mahasiswa dengan id 3
        $mahasiswa = Mahasiswa::find(3);

        // Cari matakuliah dengan id 4
        $matakuliah = Matakuliah::find(4);

        // Lakukan proses attach, yakni hubungkan mahasiswa dan matakuliah
        $mahasiswa->matakuliahs()->attach($matakuliah);

        echo "Proses attach berhasil";
        // Cek dengan cara lihat isi tabel mahasiswa_matakuliah
        // Perhatikan bahwa kolom update_at dan modified_at masih NULL
        // Untuk menambahkannya, ubah model Mahasiswa menjadi
        // return $this->belongsToMany('App\Models\Matakuliah')->withTimestamps();
        // Untuk uji coba, hapus kolom dari cmd atau phpmyadmin dan jalankan lagi attach
    }

    public function attachArray()
    {
        // Cari mahasiswa yang bernama 'Tiara Siregar'
        $mahasiswa = Mahasiswa::where('nama','Tiara Siregar')->first();
        // untuk memastikan data sesuai, bisa jalankan dd($mahasiswa);

        // Cari matakuliah dengan id 1, 2 dan 3
        // Saya menggunakan variabel penampung $matakuliahs (jamak) karena mata kuliah akan lebih dari 1 (berbentuk collection)
        $matakuliahs = Matakuliah::find([1,2,3]);
        // untuk memastikan data sesuai, jalankan dd($matakuliahs);

        // Lakukan proses attach
        $mahasiswa->matakuliahs()->attach($matakuliahs);

        echo "Proses attach berhasil";
        // lihatkan lagi isi tabel mahasiswas_matakuliah
    }

    public function attachWhere()
    {
        // Cari mahasiswa yang bernama 'Hesti Ramadan'
        $mahasiswa = Mahasiswa::where('nama','Hesti Ramadan')->first();
        // untuk memastikan data sesuai, jalankan dd($mahasiswa);

        // Cari semua matakuliah dengan sks 3
        $matakuliahs = Matakuliah::where('jumlah_sks',3)->get();
        // untuk memastikan data sesuai, jalankan dd($matakuliahs);

        // Lakukan proses attach
        $mahasiswa->matakuliahs()->attach($matakuliahs);

        echo "Proses attach berhasil";
    }

    public function tampil()
    {
        // Cari mahasiswa yang bernama 'Tiara Siregar', lalu dump property matakuliahs
        // $mahasiswa = Mahasiswa::where('nama','Tiara Siregar')->first();
        // dump($mahasiswa->matakuliahs);

        // Cari mahasiswa yang bernama 'Tiara Siregar'
        $mahasiswa = Mahasiswa::where('nama','Tiara Siregar')->first();

        echo "## Daftar mata kuliah yang diambil $mahasiswa->nama ## ";
        echo "<hr>";

        // pakai perulangan untuk menampilkan setiap object matakuliah
        foreach ($mahasiswa->matakuliahs as $matakuliah)
        {
            echo "$matakuliah->id | $matakuliah->kode:
                  $matakuliah->nama ($matakuliah->jumlah_sks sks) <br>";
        }
    }

    public function relationshipCount()
    {
        // Cari total jumlah mahasiswa tanpa perlu me-load mahasiswa
        $mahasiswas = Mahasiswa::withCount('matakuliahs')->get();

        // Cek hasil, akan ada tambahan 1 kolom bernama mahasiswas_count
        // dd($mahasiswas->toArray());

        // Akses dengan cara biasa
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama sudah mengambil
                  $mahasiswa->matakuliahs_count matakuliah <br> ";
        }
    }


    public function detach()
    {
        // Cari mahasiswa yang bernama 'Tiara Siregar'
        $mahasiswa = Mahasiswa::where('nama','Tiara Siregar')->first();
        // untuk memastikan data sesuai, jalankan dd($mahasiswa);

        // Cari matakuliah dengan nama matkul Kriptografi
        $matakuliah = Matakuliah::where('nama',"Kriptografi")->first();
        // untuk memastikan data sesuai, jalankan dd($matakuliah);

        // Lakukan proses detach
        $mahasiswa->matakuliahs()->detach($matakuliah);

        echo "Proses detach berhasil";
        // cek kembali dengan akses URL tampil() sebelumnya
    }

    public function sync()
    {
        // Cari mahasiswa yang bernama 'Tiara Siregar'
        $mahasiswa = Mahasiswa::where('nama','Tiara Siregar')->first();
        // dd($mahasiswa);
        // perhatikan bahwa Tiara Siregar saat ini mengambil 5 buah mata kuliah (2 diantaranya double)

        // Cari matakuliah dengan id 4, dan 5
        $matakuliahs = Matakuliah::find([4,5]);

        // Lakukan proses sync
        $mahasiswa->matakuliahs()->sync($matakuliahs);

        echo "Proses sync berhasil";
    }

    public function syncLagi()
    {
        $mahasiswa   = Mahasiswa::where('nama','Tiara Siregar')->first();
        $matakuliahs = Matakuliah::find([2,3,4]);

        $mahasiswa->matakuliahs()->sync($matakuliahs);
        echo "Proses sync berhasil";
    }

    public function syncChaining()
    {
        // Cari mahasiswa yang bernama 'Tiara Siregar', lalu lansung sync dengan matakuliah ber-id 1 dan 5
        Mahasiswa::where('nama','Tiara Siregar')->first()->matakuliahs()
                   ->sync(Matakuliah::find([1,5]));

        echo "Proses sync berhasil";
        // Memang singkat, tapi kadang jadi susah dipahami
    }

    public function syncWithout()
    {
        // Jika tidak ingin menghapus data sebelumnya, gunakan syncWithoutDetaching.
        $mahasiswa   = Mahasiswa::where('nama','Tiara Siregar')->first();
        $matakuliahs = Matakuliah::find([3,4]);
        // dd($matakuliahs);

        // Lakukan proses syncWithoutDetaching
        $mahasiswa->matakuliahs()->syncWithoutDetaching($matakuliahs);

        echo "Proses syncWithoutDetaching berhasil";
        // cek bahwa mata kuliah akan bertambah 2, tapi tidak menghapus yang lama.
        // Jika URL ini dijalankan sekali lagi, tetap tidak menghapus yang lama
    }

    public function toggle()
    {
        // Toggle akan memeriksa isi tabel, jika sudah ada maka akan dihapus, jika belum maka akan ditambah
        $mahasiswa   = Mahasiswa::where('nama','Tiara Siregar')->first();
        $matakuliahs = Matakuliah::where('nama','Kriptografi')->get();
        // dd($matakuliahs);

        // Lakukan proses toggle
        $mahasiswa->matakuliahs()->toggle($matakuliahs);

        echo "Proses toggle berhasil";
    }

    public function delete()
    {
        $mahasiswa = Mahasiswa::where('nama','Tiara Siregar')->first();
        $mahasiswa->delete();
        echo "Data $mahasiswa->nama berhasil di hapus";

        // Maka isi tabel mahasiswa_matakuliah juga akan dihapus, cek di phpmyadmin atau cmd
        // Cek tampil(), hasilnya akan error karena kita tidak mengantisipasi mahasiswa yang tidak ada.
        // Solusinya bisa ganti first() dengan firstOrFail() di method tampil()
    }
}
