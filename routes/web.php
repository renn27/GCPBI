<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExportController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/import', [ImportController::class, 'store'])->name('import.store');
Route::get('/export/wilayah', [ExportController::class, 'wilayah'])->name('export.wilayah');
Route::get('/export/petugas', [ExportController::class, 'petugas'])->name('export.petugas');
Route::get('/petugas/{petugas}', [PetugasController::class, 'show'])->name('petugas.show');
