<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;

Route::get('/jurusan/all',          [JurusanController::class,'all']);
Route::get('/jurusan/gabung',       [JurusanController::class,'gabung']);
Route::get('/jurusan/gabung-join',  [JurusanController::class,'gabungJoin']);


Route::prefix('/jurusan')->group(function () {
  Route::get('/find',               [JurusanController::class,'find']);
  Route::get('/where',              [JurusanController::class,'where']);
  Route::get('/all-join',           [JurusanController::class,'allJoin']);

  Route::get('/has',                [JurusanController::class,'has']);
  Route::get('/where-has',          [JurusanController::class,'whereHas']);
  Route::get('/doesnt-have',        [JurusanController::class,'doesntHave']);

  Route::get('/with-count',         [JurusanController::class,'withCount']);
  Route::get('/load-count',         [JurusanController::class,'loadCount']);

  Route::get('/insert-save',        [JurusanController::class,'insertSave']);
  Route::get('/insert-create',      [JurusanController::class,'insertCreate']);
  Route::get('/insert-create-many', [JurusanController::class,'insertCreateMany']);

  Route::get('/update',             [JurusanController::class,'update']);
  Route::get('/update-push',        [JurusanController::class,'updatePush']);

  Route::get('/delete',             [JurusanController::class,'delete']);
});



Route::prefix('/mahasiswa')->group(function () {
  Route::get('/find',             [MahasiswaController::class,'find']);
  Route::get('/where',            [MahasiswaController::class,'where']);
  Route::get('/where-chaining',   [MahasiswaController::class,'whereChaining']);
  Route::get('/has',              [MahasiswaController::class,'has']);
  Route::get('/where-has',        [MahasiswaController::class,'whereHas']);
  Route::get('/doesnt-have',      [MahasiswaController::class,'doesntHave']);

  Route::get('/associate',        [MahasiswaController::class,'associate']);

  Route::get('/associate-update', [MahasiswaController::class,'associateUpdate']);

  Route::get('/delete',           [MahasiswaController::class,'delete']);
  Route::get('/dissociate',       [MahasiswaController::class,'dissociate']);
});
