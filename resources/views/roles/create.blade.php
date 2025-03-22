@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($rol) ? 'Editar Rol' : 'Crear Rol' }}</h2>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($rol) ? route('roles.update', $rol->id) : route('roles.store') }}" method="POST">
        @csrf {{-- Protección contra ataques CSRF --}}

        @if (isset($rol))
            @method('PUT') {{-- Método HTTP para actualización --}}
        @endif

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $rol->nombre ?? '') }}">
        </div>

        @if (isset($rol))
            <div class="mb-3">
                <label for="estado" class="form-label">Cambiar estado</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($rol->getEstadosValidos() as $estado)
                        @php
                            $valorEstado = $estado->value;
                            $seleccionado = old('estado', $rol->estado ?? '') == $valorEstado ? 'selected' : '';
                        @endphp
                        <option  value="{{ $estado->value }}"  {{ $seleccionado }} >
                            {{ strtoupper($estado->value) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <label for="permiso[]" class="form-label">Agregar permisos</label>
        <div class="list-group mb-3">
            @php
                $permisosDelRol =  isset($rol) ? $rol->getPermisosIds() : [];
            @endphp
            @foreach($permisos as $permiso)
                <label class="list-group-item">
                    <input 
                        class="form-check-input me-2" 
                        type="checkbox" 
                        name="permisos[]" 
                        value="{{ $permiso->id }}"
                        {{ in_array($permiso->id, $permisosDelRol) ? 'checked' : '' }}
                    >
                    {{ $permiso->nombre }}
                </label>
             @endforeach

            @if (count($permisos) == 0)
              <div class="alert alert-danger" role="alert">
                No hay permisos disponibles
              </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($rol) ? 'Actualizar Rol' : 'Crear Rol' }}</button>
        <a href="{{ route('roles.index')}}" class="btn btn-danger">Cancelar</a>
    </form>
</div>
@endsection