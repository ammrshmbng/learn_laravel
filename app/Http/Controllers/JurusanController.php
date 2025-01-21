<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Jurusan;
use App\Models\Mahasiswa;

class JurusanController extends Controller
{

    // ==========================
    // RAW QUERY
    // ==========================

    public function all()
    {
        // Ambil semua isi tabel jurusans
        $jurusans = DB::select('SELECT * FROM jurusans');
        foreach ($jurusans as $jurusan) {
            echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | ";
            echo "$jurusan->daya_tampung <br>";
        }
    }

    public function gabung()
    {
        // Ambil semua isi tabel jurusans dan mahasiswas menggunakan raw query
        // $result = DB::select('SELECT * FROM jurusans, mahasiswas WHERE
        //             jurusans.id = mahasiswas.jurusan_id');
        // dump($result);

        // jika menggunakan ini, ada ambigu dalam penamaan kolom "nama", "id",
        // jadi untuk amannya buat menjadi alias, kecuali tidak ada nama kolom yang sama

        $result = DB::select(
                    'SELECT
                    jurusans.nama as nama_jurusan,
                    mahasiswas.id as id_mahasiswa,
                    mahasiswas.nama as nama_mahasiswa
                    FROM jurusans, mahasiswas
                    WHERE jurusans.id = mahasiswas.jurusan_id'
                  );
        // dd($result);

        foreach ($result as $row) {
            echo "$row->nama_jurusan | $row->nama_mahasiswa ($row->id_mahasiswa) <br>";
        }
    }

    public function gabungJoin()
    {
        // Ambil semua isi tabel jurusans dan mahasiswas menggunakan raw query JOIN
        $result = DB::select(
                   'SELECT
                    jurusans.nama as nama_jurusan,
                    mahasiswas.id as id_mahasiswa,
                    mahasiswas.nama as nama_mahasiswa
                    FROM jurusans JOIN mahasiswas
                    ON jurusans.id = mahasiswas.jurusan_id
                    WHERE jurusans.nama = "Sistem Informasi"
                    ORDER BY mahasiswas.id'
                   );
        foreach ($result as $row) {
            echo "$row->nama_jurusan | $row->nama_mahasiswa ($row->id_mahasiswa) <br>";
        }
    }


    // ==========================
    // ELOQUENT RELATIONSHIP
    // ==========================

    public function find()
    {
        // Ambil data mahasiswa dengan id 1
        // $jurusan = Jurusan::find(1);

        // echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | ";
        // echo "$jurusan->daya_tampung <br>";

        // Untuk mengakses mahasiswa dari jurusan ini, bisa diakses dari $jurusan->mahasiswas
        // $jurusan = Jurusan::find(1);
        // dump($jurusan->mahasiswas);

        // Mahasiswa tersimpan sebagai collection atau array
        // Agar lebih mudah dilihat, pakai method toArray()
        // $jurusan = Jurusan::find(1);
        // dump($jurusan->mahasiswas->toArray());

        // Karena mahasiswa berbentuk array, maka bisa ditampilkan dengan perulangan
        $jurusan = Jurusan::find(1);
        echo "Jurusan $jurusan->nama <br>";
        echo "Nama Kepala Jurusan : $jurusan->kepala_jurusan <br>";
        echo "Daya Tampung        : $jurusan->daya_tampung orang <hr>";

        echo "## Daftar Mahasiswa ##";
        echo "<br><br>";
        foreach ($jurusan->mahasiswas as $mahasiswa){
            echo "$mahasiswa->nama ($mahasiswa->nim) <br>";
        }
    }

    public function where()
    {
        // Tampilkan semua mahasiswa yang mengambil jurusan dengan nama Kepala Jurusan 'Dr. Umar Agustinus, M.Sc.'
        $jurusan = Jurusan::where('kepala_jurusan','Dr. Umar Agustinus, M.Sc.')
                   ->first();

        echo "Jurusan $jurusan->nama <br>";
        echo "Nama Kepala Jurusan : $jurusan->kepala_jurusan <br>";
        echo "Daya Tampung        : $jurusan->daya_tampung orang <hr>";

        echo "## Daftar Mahasiswa ##";
        echo "<br><br>";
        foreach ($jurusan->mahasiswas as $mahasiswa){
            echo "$mahasiswa->nama ($mahasiswa->nim) <br>";
        }
    }

    public function allJoin()
    {
        // Tampilkan semua jurusan beserta semua mahasiswa
        // $jurusans = Jurusan::all();

        // foreach ($jurusans as $jurusan){
        //     echo "Jurusan $jurusan->nama ($jurusan->daya_tampung orang)<br> ";
        //     echo "Kepala Jurusan: $jurusan->kepala_jurusan <br> ";
        //     echo "Mahasiswa: ";
        //     foreach ($jurusan->mahasiswas as $mahasiswa){
        //         echo "$mahasiswa->nama ($mahasiswa->nim), ";
        //     }
        //     echo "<hr>";
        // }

       // Versi Eager Loading
       $jurusans = Jurusan::with('mahasiswas')->get();

       foreach ($jurusans as $jurusan){
            echo "Jurusan $jurusan->nama ($jurusan->daya_tampung orang)<br> ";
            echo "Kepala Jurusan: $jurusan->kepala_jurusan <br> ";
            echo "Mahasiswa: ";
            foreach ($jurusan->mahasiswas as $mahasiswa){
                echo "$mahasiswa->nama ($mahasiswa->nim), ";
            }
            echo "<hr>";
       }
    }

    public function has()
    {
        // Tampilkan semua jurusan yang memiliki mahasiswa
        $jurusans = Jurusan::has('mahasiswas')->get();

        foreach ($jurusans as $jurusan) {
            echo "$jurusan->nama | ";
        }
    }

    public function whereHas()
    {
        // Tampilkan nama jurusan yang memiliki mahasiswa yang diawali dengan huruf R
        $jurusans = Jurusan::whereHas('mahasiswas', function ($query) {
            $query->where('nama','like' ,'M%');
        })->get();

        foreach ($jurusans as $jurusan) {
            echo "$jurusan->nama | ";
        }
    }

    public function doesntHave()
    {
        // Tampilkan semua jurusan yang belum memiliki mahasiswa
        $jurusans = Jurusan::doesntHave('mahasiswas')->get();

        foreach ($jurusans as $jurusan) {
            echo "$jurusan->nama | ";
        }
    }


    public function withcount()
    {
        // Cari total jumlah mahasiswa tanpa perlu me-load mahasiswa
        $jurusans = Jurusan::withCount('mahasiswas')->get();

        // Cek hasil, akan ada tambahan 1 kolom bernama mahasiswas_count
        dump($jurusans->toArray());

        // Akses dengan cara biasa
        // foreach ($jurusans as $jurusan) {
        //     echo "$jurusan->nama ($jurusan->mahasiswas_count mahasiswa) <br> ";
        // }
    }

    public function loadCount()
    {
        // Cari jurusan dengan nama Kepala Jurusan 'Dr. Umar Agustinus, M.Sc.'
        $jurusan = Jurusan::where('kepala_jurusan','Dr. Umar Agustinus, M.Sc.')
                   ->first();
        // dd($jurusans->toArray());
        // Disini belum ada kolom mahasiswas_count

        // Tambahkan kolom mahasiswas_count dengan perintah ini
        $jurusan->loadCount('mahasiswas');
        // dd($jurusan->toArray());
        // Sekarang sudah ada tambahan kolom mahasiswas_count

        // Akses dengan cara biasa
        echo "$jurusan->nama ($jurusan->mahasiswas_count mahasiswa) <br> ";
    }

    public function insertSave()
    {
        // Penambahan data ke kedua tabel, cara 1 pakai method save()
        $jurusan = new Jurusan;
        $jurusan->nama = 'Farmasi';
        $jurusan->kepala_jurusan = 'Prof. Silvia Nst, M.Farm';
        $jurusan->daya_tampung = 125;
        $jurusan->save();

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = '19001516';
        $mahasiswa->nama = 'Christine Wijaya';

        $jurusan->mahasiswas()->save($mahasiswa);  // Agar tidak perlu mencari ID jurusan
        echo "Penambahan jurusan $jurusan->nama dan
              mahasiswa $mahasiswa->nama ke database berhasil";
    }


    public function insertCreate()
    {
        // Penambahan data, cara 2 pakai method create()
        // Karena ini one to many, biasanya yang sering ditambah itu adalah tabel ke-2
        // Jadi kita pakai pencarian saja
        // Ini mengggunakan Mass Asignment, jadi tambahkan protected $guarded = []; ke model Mahasiswa

        $jurusan = Jurusan::where('nama','Ilmu Komputer')->first();

        $jurusan->mahasiswas()->create([
            'nim' => '19001912',
            'nama' => 'Bobby Permana',
        ]);

        echo "Penambahan mahasiswa ke database berhasil";
    }

    public function insertCreateMany()
    {
        // Penambahan beberapa data mahasiswa ke jurusan

        $jurusan = Jurusan::where('nama','Sistem Informasi')->first();

        $jurusan->mahasiswas()->createMany([
            [
                'nim' => '19002345',
                'nama' => 'Jessica Irwan'
            ],
            [
                'nim' => '19005007',
                'nama' => 'Lara Permata'
            ]
        ]);

        echo "Penambahan mahasiswa ke database berhasil";
    }


    public function update()
    {
        // Cari semua mahasiswa jurusan Ilmu Komputer, lalu pindahkan ke Sistem Informasi
        $jurusan_ilkom = Jurusan::where('nama','Ilmu Komputer')->first();
        $jurusan_si = Jurusan::where('nama','Sistem Informasi')->first();

        $jurusan_ilkom->mahasiswas()->update ([
            'jurusan_id' => $jurusan_si->id,
        ]);

        echo "Semua mahasiswa $jurusan_ilkom->nama sudah sudah pindah
              ke $jurusan_si->nama";
    }

    public function updatePush()
    {
        // Cari semua mahasiswa jurusan Sistem Informasi, lalu tambah akhiran "S.Kom" ke dalam nama
        $jurusan = Jurusan::where('nama','Sistem Informasi')->first();

        foreach ($jurusan->mahasiswas as $mahasiswa) {
            $mahasiswa->nama = $mahasiswa->nama." S.Kom";
            $mahasiswa->push();
            echo "Berhasil update nama mahasiswa menjadi
                  $mahasiswa->nama <br>";
        }
    }

    public function delete()
    {
        // Karena di database sudah di set sebagai cascade, maka jika jurusan di hapus, semua mahasiswa akan juga ikut terhapus
        // Pakai firstOrFail() agar langsung 404 jika jurusan tidak ditemukan
        $jurusan = Jurusan::where('nama','Sistem Informasi')->firstOrFail();
        $jurusan->delete();
        echo "Jurusan $jurusan->nama beserta semua mahasiswa sudah dihapus";
    }
}
