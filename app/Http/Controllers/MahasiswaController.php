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
        $validateData = $request->validate([
            'nim'           => 'required|size:8',
            'nama'          => 'required|min:3|max:50',
            'email'         => 'required|email',
            'jenis_kelamin' => 'required|in:P,L',
            'jurusan'       => 'required',
            'alamat'        => '',
        ]);

        dump ($validateData);

        echo $validateData['nim'];           echo "<br>";
        echo $validateData['nama'];          echo "<br>";
        echo $validateData['email'];         echo "<br>";
        echo $validateData['jenis_kelamin']; echo "<br>";
        echo $validateData['jurusan'];       echo "<br>";
        echo $validateData['alamat'];

    }
}
