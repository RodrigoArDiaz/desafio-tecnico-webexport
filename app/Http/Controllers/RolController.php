<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolRequest;
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
                            ->with('error', 'Ocurrió un error al crear el usuario.');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
