<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaOutdoorController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('agenda', AgendaOutdoorController::class);