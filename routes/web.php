<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaOutdoorController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\IbadahController;



// --- 1. HALAMAN UTAMA & DASHBOARD (WAJIB LOGIN) ---
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


// --- 2. AUTENTIKASI (HANYA UNTUK YANG BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- 3. FITUR-FITUR APLIKASI (SEMUA WAJIB LOGIN) ---
Route::middleware(['auth'])->group(function () {
    
    // A. AGENDA OUTDOOR
    Route::get('agenda/cetak_pdf', [AgendaOutdoorController::class, 'cetakPdf'])->name('agenda.cetak');
    Route::resource('agenda', AgendaOutdoorController::class);

    // A1. AJAX Wilayah (untuk cascading dropdown)
    Route::get('wilayah/provinsi',          [AgendaOutdoorController::class, 'getProvinsi'])->name('wilayah.provinsi');
    Route::get('wilayah/kabupaten/{prov}',  [AgendaOutdoorController::class, 'getKabupaten'])->name('wilayah.kabupaten');
    Route::get('wilayah/kecamatan/{kab}',   [AgendaOutdoorController::class, 'getKecamatan'])->name('wilayah.kecamatan');
    Route::get('wilayah/kelurahan/{kec}',   [AgendaOutdoorController::class, 'getKelurahan'])->name('wilayah.kelurahan');

    // B. MANAJEMEN TUGAS
    Route::get('/tugas/cetak', [TugasController::class, 'exportPdf'])->name('tugas.export');
    Route::resource('tugas', TugasController::class)->except(['show']);

    // C. MEAL PLAN
    Route::prefix('meal-plan')->name('mealplan.')->group(function () {
        Route::get('/', [MealPlanController::class, 'index'])->name('index');
        Route::post('/store', [MealPlanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MealPlanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MealPlanController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [MealPlanController::class, 'destroy'])->name('destroy');
        Route::get('/cetak', [MealPlanController::class, 'cetak'])->name('cetak');
    });
    Route::get('/recipe-detail/{id}', [MealPlanController::class, 'showRecipe'])->name('recipe.detail');

    // D. SPIRITUAL / IBADAH
    Route::get('/spiritual', [IbadahController::class, 'index'])->name('spiritual.index');
    Route::prefix('spiritual')->name('spiritual.')->group(function () {
        Route::post('/store', [IbadahController::class, 'store'])->name('store');
        Route::put('/update/{id}', [IbadahController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [IbadahController::class, 'destroy'])->name('destroy');
        Route::post('/set-agama', [IbadahController::class, 'simpanAgama'])->name('setAgama');
        Route::get('/cetak-pdf', [IbadahController::class, 'cetakPdf'])->name('cetak');
    });

});