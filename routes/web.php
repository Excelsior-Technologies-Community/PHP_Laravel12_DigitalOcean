<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DigitalOceanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/regions', [DigitalOceanController::class, 'regions']);
Route::get('/sizes', [DigitalOceanController::class, 'sizes']);
Route::get('/droplets', [DigitalOceanController::class, 'droplets']);
