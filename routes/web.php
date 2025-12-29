<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealPlanController;

Route::get('/meal-plan', [MealPlanController::class, 'index'])->name('mealplan.index');
Route::post('/meal-plan/store', [MealPlanController::class, 'store'])->name('mealplan.store');
Route::put('/meal-plan/update/{id}', [MealPlanController::class, 'update'])->name('mealplan.update');
Route::delete('/meal-plan/destroy/{id}', [MealPlanController::class, 'destroy'])->name('mealplan.destroy');
Route::get('/meal-plan/{id}/edit', [MealPlanController::class, 'edit'])->name('mealplan.edit');
Route::put('/meal-plan/{id}', [MealPlanController::class, 'update'])->name('mealplan.update');
Route::get('/recipe-detail/{id}', [MealPlanController::class, 'showRecipe'])->name('recipe.detail');
Route::get('/meal-plan/cetak', [MealPlanController::class, 'cetak'])->name('mealplan.cetak');

Route::get('/', function () {
    return view('welcome');
});
