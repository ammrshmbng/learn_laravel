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


// error no semicolon
// Route::get('/hello', function () {
//     return 'Hello World'
// });


// Attribute [gets] does not exist
// Route::gets('/hello', function () {
//     return 'Hello World';
//  });



// console.log(var_dump)
// Route::get('/hello', function () {
//     $hello = 'Hello World';
//     var_dump($hello);
//     return $hello;
//     });


// dd
// Route::get('/hello', function () {
//     $hello = 'Hello World';
//     dd($hello);
// });


Route::get('hello', function () {
    $hello = ['Hello World', 2 => ['Hello Jakarta','Hello Medan']];
    dd($hello);
    return $hello;
    });
