<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaOutdoorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('agenda/cetak_pdf', [AgendaOutdoorController::class, 'cetakPdf'])->name('agenda.cetak');

Route::resource('agenda', AgendaOutdoorController::class);

Route::resource('agenda', AgendaOutdoorController::class);

Route::get('agenda/cetak_pdf', [AgendaOutdoorController::class, 'cetakPdf'])->name('agenda.cetak');

Route::resource('agenda', AgendaOutdoorController::class);