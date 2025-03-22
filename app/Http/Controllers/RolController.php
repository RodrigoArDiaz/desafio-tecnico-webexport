<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolRequest;
use App\Http\Requests\UpdateRolRequest;
use App\Models\Rol;
use Exception;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Muestra una lista de todos los roles.
     */
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Muestra la vista para crear un nuevo rol.
     */
    public function create()
    {
       return view('roles.create');
    }

    /**
     * Guarda un nuevo rol.
     */
    public function store(StoreRolRequest $request)
    {
        try {
            Rol::create([
                'nombre' => $request->input('nombre'),
            ]);

            return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('roles.index')
                            ->with('error', 'Ocurrió un error al crear el rol.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra la vista para actualizar un rol.
     */
    public function edit(string $id)
    {
        try {
            $rol = Rol::find($id);
            if (!$rol) {
                return redirect()->route('roles.index')
                                ->with('error', 'El rol no existe.');
            }
            return view('roles.create', [
                'rol' => $rol
            ]);
        } catch (Exception $e) {
            return redirect()->route('roles.index')
                             ->with('error', 'Ocurrió un error al actualizar el rol.');
        }
    }

    /**
     * Actualiza rol segun su id.
     */
    public function update(UpdateRolRequest $request, string $id)
    {
        try {
            $rol = Rol::find($id);
            if (!$rol) {
                return redirect()->route('roles.index')
                                ->with('error', 'El rol no existe.');
            }

            $rol->update([
                'nombre' => $request->input('nombre'),
                'estado' => $request->filled('estado') ? $request->input('estado') : $rol->estado,
            ]);

            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');

        } catch (Exception $e) {
            return redirect()->route('roles.index')
                            ->with('error', 'Ocurrió un error al actualizar el rol.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
