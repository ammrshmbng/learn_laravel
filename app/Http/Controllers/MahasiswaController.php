<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('form-pendaftaran');
    }

    public function prosesForm(Request $request)
    {
        echo $request->nim;
        echo "<br>";
        echo $request->nama;
        echo "<br>";
        echo $request->email;
        echo "<br>";
        echo $request->jenis_kelamin;
        echo "<br>";
        echo $request->jurusan;
        echo "<br>";
        echo $request->alamat;
        dump($request);
    }
}
