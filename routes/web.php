<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\AgendaOutdoorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealPlanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IbadahController;

Route::get('/meal-plan', [MealPlanController::class, 'index'])->name('mealplan.index');
Route::post('/meal-plan/store', [MealPlanController::class, 'store'])->name('mealplan.store');
Route::put('/meal-plan/update/{id}', [MealPlanController::class, 'update'])->name('mealplan.update');
Route::delete('/meal-plan/destroy/{id}', [MealPlanController::class, 'destroy'])->name('mealplan.destroy');
Route::get('/meal-plan/{id}/edit', [MealPlanController::class, 'edit'])->name('mealplan.edit');
Route::put('/meal-plan/{id}', [MealPlanController::class, 'update'])->name('mealplan.update');
Route::get('/recipe-detail/{id}', [MealPlanController::class, 'showRecipe'])->name('recipe.detail');
Route::get('/meal-plan/cetak', [MealPlanController::class, 'cetak'])->name('mealplan.cetak');


Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create');
Route::get('/tugas/export', [TugasController::class, 'exportPdf'])->name('tugas.export');
Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');

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
