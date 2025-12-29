<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [TugasController::class, 'index'])->name('tugas.index');

Route::get('/tugas/cetak', [TugasController::class, 'exportPdf'])->name('tugas.export');

Route::resource('tugas', TugasController::class)->except(['show']);

Route::get('tugas/export', [TugasController::class, 'exportPdf'])->name('tugas.export');
