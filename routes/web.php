<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/cek-object',      [MahasiswaController::class,'cekObject']);

Route::get('/insert',          [MahasiswaController::class,'insert']);
Route::get('/mass-assignment', [MahasiswaController::class,'massAssignment']);
Route::get('/mass-assignment2',[MahasiswaController::class,'massAssignment2']);

Route::get('/update',          [MahasiswaController::class,'update']);
Route::get('/update-where',    [MahasiswaController::class,'updateWhere']);
Route::get('/mass-update',     [MahasiswaController::class,'massUpdate']);

Route::get('/delete',          [MahasiswaController::class,'delete']);
Route::get('/destroy',         [MahasiswaController::class,'destroy']);
Route::get('/mass-delete',     [MahasiswaController::class,'massDelete']);

Route::get('/all',             [MahasiswaController::class,'all']);
Route::get('/all-view',        [MahasiswaController::class,'allView']);
Route::get('/get-where',       [MahasiswaController::class,'getWhere']);
Route::get('/test-where',      [MahasiswaController::class,'testWhere']);
Route::get('/first',           [MahasiswaController::class,'first']);
Route::get('/find',            [MahasiswaController::class,'find']);
Route::get('/latest',          [MahasiswaController::class,'latest']);
Route::get('/limit',           [MahasiswaController::class,'limit']);
Route::get('/skip-take',       [MahasiswaController::class,'skipTake']);

Route::get('/soft-delete',     [MahasiswaController::class,'softDelete']);
Route::get('/with-trashed',    [MahasiswaController::class,'withTrashed']);
Route::get('/restore',         [MahasiswaController::class,'restore']);
Route::get('/force-delete',    [MahasiswaController::class,'forceDelete']);
