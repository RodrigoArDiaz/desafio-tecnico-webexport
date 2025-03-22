<?php

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('inicio');

Route::resource('usuarios', UsuarioController::class);

Route::resource('roles', RolController::class);