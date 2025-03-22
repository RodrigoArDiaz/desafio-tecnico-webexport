<?php

namespace App\Http\Controllers;

use App\Enums\Genero;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Exception;
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
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return redirect()->route('usuarios.index')
                             ->with('error', 'El usuario no existe.');
        }
        $generos = Genero::cases();
        return view('usuarios.create', [
            'usuario' => $usuario,
            'generos' => $generos
        ]);
    }

    /**
     * Actualiza usuario segun su id.
     */
    public function update(UpdateUsuarioRequest $request, string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return redirect()->route('usuarios.index')
                             ->with('error', 'El usuario no existe.');
        }

        $usuario->update([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'dni' => $request->input('dni'),
            'mail' => $request->input('mail'),
            'fecha_de_nacimiento' => $request->input('fecha_de_nacimiento'),
            'genero' => $request->input('genero'),
            'contrasenia' => $request->filled('contrasenia') ? $request->input('contrasenia') : $usuario->contrasenia,
            'estado' => $request->filled('estado') ? $request->input('estado') : $usuario->estado,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina usuario segun su id. 
     */
    public function destroy(string $id)
    {
        try {
            $usuario = Usuario::find($id);
            if (!$usuario) {
                return redirect()->route('usuarios.index')
                                ->with('error', 'El usuario no existe.');
            }
            $usuario->roles()->detach();

            $usuario->delete();

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');

        } catch (Exception $e) {
            return redirect()->route('usuarios.index')
                             ->with('error', 'Ocurrió un error al eliminar el usuario.');
        }
    }
}
