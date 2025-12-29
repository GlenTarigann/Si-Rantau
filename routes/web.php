<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IbadahController; 

Route::get('/', function () {
    return redirect()->route('spiritual.index');
});

Route::get('/spiritual', [IbadahController::class, 'index'])->name('spiritual.index');
Route::prefix('spiritual')->name('spiritual.')->group(function () {
    
    Route::post('/store', [IbadahController::class, 'store'])->name('store');
    
    Route::put('/update/{id}', [IbadahController::class, 'update'])->name('update');
    
    Route::delete('/destroy/{id}', [IbadahController::class, 'destroy'])->name('destroy');
    
    Route::post('/set-agama', [IbadahController::class, 'simpanAgama'])->name('setAgama');

    Route::get('/cetak-pdf', [IbadahController::class, 'cetakPdf'])->name('cetak');
});

