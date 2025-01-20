<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NilaiController;

// Praktek raw query

Route::get('/mahasiswa/all',           [MahasiswaController::class,'all']);
Route::get('/mahasiswa/gabung-1',      [MahasiswaController::class,'gabung1']);
Route::get('/mahasiswa/gabung-2',      [MahasiswaController::class,'gabung2']);
Route::get('/mahasiswa/gabung-join-1', [MahasiswaController::class,'gabungJoin1']);
Route::get('/mahasiswa/gabung-join-2', [MahasiswaController::class,'gabungJoin2']);
Route::get('/mahasiswa/gabung-join-3', [MahasiswaController::class,'gabungJoin3']);


// Praktek Eloquent Relationship hasOne()

Route::prefix('/mahasiswa')->group(function () {
  Route::get('/find',              [MahasiswaController::class,'find']);
  Route::get('/where',             [MahasiswaController::class,'where']);
  Route::get('/where-chaining',    [MahasiswaController::class,'whereChaining']);
  Route::get('/all-join',          [MahasiswaController::class,'allJoin']);
  Route::get('/has',               [MahasiswaController::class,'has']);
  Route::get('/where-has',         [MahasiswaController::class,'whereHas']);
  Route::get('/doesnt-have',       [MahasiswaController::class,'doesntHave']);
  Route::get('/where-doesnt-have', [MahasiswaController::class,'whereDoesntHave']);

  Route::get('/insert-save',       [MahasiswaController::class,'insertSave']);
  Route::get('/insert-create',     [MahasiswaController::class,'insertCreate']);

  Route::get('/update',            [MahasiswaController::class,'update']);
  Route::get('/update-push',       [MahasiswaController::class,'updatePush']);
  Route::get('/update-push-where', [MahasiswaController::class,'updatePushWhere']);

  Route::get('/delete-find',       [MahasiswaController::class,'deleteFind']);
  Route::get('/delete-where',      [MahasiswaController::class,'deleteWhere']);
  Route::get('/delete-if',         [MahasiswaController::class,'deleteIf']);
  Route::get('/delete-cascade',    [MahasiswaController::class,'deleteCascade']);
  Route::get('/update-cascade',    [MahasiswaController::class,'updateCascade']);

});


// Praktek Eloquent Relationship belongsTo()

Route::prefix('/nilai')->group(function () {
  Route::get('/find',              [NilaiController::class,'find']);
  Route::get('/where',             [NilaiController::class,'where']);
  Route::get('/where-chaining',    [NilaiController::class,'whereChaining']);
  Route::get('/has',               [NilaiController::class,'has']);
  Route::get('/has-eager',         [NilaiController::class,'hasEager']);

  Route::get('/test-input-1',      [NilaiController::class,'testInput1']);
  Route::get('/test-input-2',      [NilaiController::class,'testInput2']);
  Route::get('/test-input-3',      [NilaiController::class,'testInput3']);
  Route::get('/test-input-4',      [NilaiController::class,'testInput4']);

  Route::get('/associate-new',     [NilaiController::class,'associateNew']);
  Route::get('/associate-find',    [NilaiController::class,'associateFind']);

  Route::get('/delete',            [NilaiController::class,'delete']);
  Route::get('/delete-mahasiswa',  [NilaiController::class,'deleteMahasiswa']);
  Route::get('/delete-mahasiswa',  [NilaiController::class,'deleteMahasiswa']);

});
