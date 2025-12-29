<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IbadahController; 

Route::get('/', function () {
    return redirect()->route('spiritual.index');
});

Route::get('/', [TugasController::class, 'index'])->name('tugas.index');

Route::get('/tugas/cetak', [TugasController::class, 'exportPdf'])->name('tugas.export');

Route::resource('tugas', TugasController::class)->except(['show']);

Route::get('tugas/export', [TugasController::class, 'exportPdf'])->name('tugas.export');
Route::get('/spiritual', [IbadahController::class, 'index'])->name('spiritual.index');
Route::prefix('spiritual')->name('spiritual.')->group(function () {
    
    Route::post('/store', [IbadahController::class, 'store'])->name('store');
    
    Route::put('/update/{id}', [IbadahController::class, 'update'])->name('update');
    
    Route::delete('/destroy/{id}', [IbadahController::class, 'destroy'])->name('destroy');
    
    Route::post('/set-agama', [IbadahController::class, 'simpanAgama'])->name('setAgama');

    Route::get('/cetak-pdf', [IbadahController::class, 'cetakPdf'])->name('cetak');
});

Route::get('agenda/cetak_pdf', [AgendaOutdoorController::class, 'cetakPdf'])->name('agenda.cetak');

Route::resource('agenda', AgendaOutdoorController::class);

Route::resource('agenda', AgendaOutdoorController::class);

Route::get('agenda/cetak_pdf', [AgendaOutdoorController::class, 'cetakPdf'])->name('agenda.cetak');

Route::resource('agenda', AgendaOutdoorController::class);
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Container\Attributes\Auth;

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
