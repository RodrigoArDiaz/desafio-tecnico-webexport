<?php

namespace App\Http\Controllers;

use App\Enums\Genero;
use App\Http\Requests\StoreUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra un listado de usuarios
     */
    public function index() : View
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    public function create() : View
    {
       $generos = Genero::cases();
       return view('usuarios.create', ['generos' => $generos]);
    }

    public function store(StoreUsuarioRequest $request)
    {
        // Crear el usuario
        Usuario::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'dni' => $request->input('dni'),
            'mail' => $request->input('mail'),
            'fecha_de_nacimiento' => $request->input('fecha_de_nacimiento'),
            'genero' => $request->input('genero'),
            'contrasenia' => $request->input('contrasenia'), // Hashea la contraseña
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
