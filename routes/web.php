<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\EsSuperAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('inicio'); // Usuario autenticado
    } else {
        return redirect()->route('login'); // Usuario no autenticado
    }
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/inicio', [UsuarioController::class, 'perfil'])->name('inicio');

    Route::middleware(EsSuperAdmin::class)->group(function () {

        Route::resource('usuarios', UsuarioController::class);

        Route::get('usuarios/{usuario}/roles', [UsuarioController::class, 'editRoles'])
            ->name('usuarios.edit_roles');

        Route::post('usuarios/{usuario}/roles', [UsuarioController::class, 'updateRoles'])
            ->name('usuarios.update_roles');

        Route::resource('roles', RolController::class)->parameters([
            'roles' => 'rol', 
        ]);
    });
});