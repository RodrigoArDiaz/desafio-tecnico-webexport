<?php

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('inicio');

Route::resource('usuarios', UsuarioController::class);

Route::get('usuarios/{usuario}/roles', [UsuarioController::class, 'editRoles'])
    ->name('usuarios.edit_roles');

Route::post('usuarios/{usuario}/roles', [UsuarioController::class, 'updateRoles'])
    ->name('usuarios.update_roles');

Route::resource('roles', RolController::class)->parameters([
    'roles' => 'rol', 
]);