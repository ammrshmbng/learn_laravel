<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mahasiswa', function () {
    return view('mahasiswa');
});


// view inside subfolder
// Route::get('/mahasiswa-univ', function () {
//     return view('universitas.mahasiswa');
// });



// mengirim data ke view
// Route::get('/mahasiswa', function () {
//     return view('universitas.mahasiswa',[
//         "mahasiswa01" => "Risa Lestari",
//         "mahasiswa02" => "Rudi Hermawan",
//         "mahasiswa03" => "Bambang Kusumo",
//         "mahasiswa04" => "Lisa Permata"
//         ]);
//     });

// Route::get('/mahasiswa', function () {
//     $arrMahasiswa = ["Risa Lestari","Rudi Hermawan","Bambang Kusumo",
//     "Lisa Permata"];
//     return view('universitas.mahasiswa',['mahasiswa' => $arrMahasiswa]);
//     });


Route::get('/mahasiswa', function () {
    $arrMahasiswa = ["Risa Lestari","Rudi Hermawan","Bambang Kusumo",
    "Lisa Permata"];
    return view('universitas.mahasiswa',['mahasiswa' => $arrMahasiswa]);
    });
