<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
