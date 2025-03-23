<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolRequest;
use App\Http\Requests\UpdateRolRequest;
use App\Models\Permiso;
use App\Models\Rol;
use Exception;
use Illuminate\Support\Facades\DB;

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
       $permisos = Permiso::all();
       return view('roles.create', ['permisos' => $permisos]);
    }

    /**
     * Guarda un nuevo rol.
     */
    public function store(StoreRolRequest $request)
    {
        try {
            $rol= Rol::create([
                'nombre' => $request->input('nombre'),
            ]);

            $permisosSeleccionados = $request->input('permisos', []);

            $rol->permisos()->attach($permisosSeleccionados);

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
            $permisos = Permiso::all();
            return view('roles.create', [
                'rol' => $rol,
                'permisos' => $permisos
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
            DB::beginTransaction();

            $rol = Rol::find($id);
            if (!$rol) {
                return redirect()->route('roles.index')
                                ->with('error', 'El rol no existe.');
            }

            $rol->update([
                'nombre' => $request->input('nombre'),
                'estado' => $request->filled('estado') ? $request->input('estado') : $rol->estado,
            ]);

            $permisosSeleccionados = $request->input('permisos', []);
            $permisosRol = $rol->getPermisosIds();

            $permisosParaBorrar = array_diff($permisosRol, $permisosSeleccionados);
            $permisosParaAgregar = array_diff($permisosSeleccionados, $permisosRol);

            $rol->permisos()->detach($permisosParaBorrar);
            $rol->permisos()->attach($permisosParaAgregar);

            DB::commit();

            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')
                            ->with('error', 'Ocurrió un error al actualizar el rol.');
        }
    }

    /**
     * Elimina un rol segun su id.
     */
    public function destroy(string $id)
    {
        try {
            $rol = Rol::find($id);
            if (!$rol) {
                return redirect()->route('roles.index')
                                ->with('error', 'El rol no existe.');
            }
            $rol->usuarios()->detach();
            $rol->permisos()->detach();

            $rol->delete();

            return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');

        } catch (Exception $e) {
            return redirect()->route('roles.index')
                             ->with('error', 'Ocurrió un error al eliminar el rol.');
        }
    }
}
