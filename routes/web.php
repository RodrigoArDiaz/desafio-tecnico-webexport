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

    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
    Route::get('perfil/{usuario}/cambiar-contrasenia', [UsuarioController::class, 'showCambiarContrasenia'])->name('cambiar-contrasenia');
    Route::put('perfil/{usuario}/cambiar-contrasenia', [UsuarioController::class, 'updateContrasenia'])->name('confirmar-cambiar-contrasenia');
    

    //Rutas para comprobar permisos 
    Route::get('/cursos', function() {
        return view('ejemplo-recursos.cursos');
    })->middleware('can:ver_cursos')
      ->name('cursos');

    Route::get('/productos', function() {
        return view('ejemplo-recursos.productos');
    })->middleware('can:ver_productos')
      ->name('productos');

});