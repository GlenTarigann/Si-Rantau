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
