<?php

namespace App\Http\Controllers;

use App\Enums\Genero;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateRolesUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Rol;
use App\Models\Usuario;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Agregar role/s a usuario segun su id. 
     */
    public function editRoles(string $id){
        try{
            $usuario = Usuario::find($id);
            if (!$usuario) {
                return redirect()->route('usuarios.index')
                                ->with('error', 'El usuario no existe.');
            }
            $roles = Rol::all();
            return view('usuarios.roles', [
                'usuario' => $usuario,
                'roles' => $roles
            ]);
        } catch (Exception $e) {
            return redirect()->route('usuarios.index')
                            ->with('error', 'Ocurrió un error al eliminar el usuario.');
        }
    }

    /**
     * Agregar role/s a usuario segun su id. 
     */
    public function updateRoles(UpdateRolesUsuarioRequest $request, string $id){
        try {
            DB::beginTransaction();

            $usuario = Usuario::find($id);
            if (!$usuario) {
                return redirect()->route('usuarios.index')
                                ->with('error', 'El usuario no existe.');
            }
            $rolesSeleccionados = $request->input('roles', []);

            $rolesDelUsuario = $usuario->getRolesIds();
            $rolesParaBorrar = array_diff($rolesDelUsuario, $rolesSeleccionados);
            $rolesParaAgregar = array_diff($rolesSeleccionados, $rolesDelUsuario);
            
            $usuario->roles()->detach($rolesParaBorrar);
            $usuario->roles()->attach($rolesParaAgregar);
        
            
            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Roles asignados a usuario exitosamente.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('usuarios.index')
                            ->with('error', 'Ocurrió un error al actualizar el rol.');
        }
    
    }

    public function perfil() : View
    {
        return view('usuarios.profile');
    }
}
