@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($usuario) ? 'Editar Usuario' : 'Crear Usuario' }}</h2>

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

    <form action="{{ isset($usuario) ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}" method="POST">
        @csrf {{-- Protección contra ataques CSRF --}}

        @if (isset($usuario))
            @method('PUT') {{-- Método HTTP para actualización --}}
        @endif

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni', $usuario->dni ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" value="{{ old('mail', $usuario->mail ?? '') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="fecha_de_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_de_nacimiento" name="fecha_de_nacimiento" value="{{ old('fecha_de_nacimiento', $usuario->fecha_de_nacimiento ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Género</label>
            <select class="form-control" id="genero" name="genero" required>
                <option value="">Seleccione una opción</option>
                @foreach($generos as $genero)
                    @php
                        $valorGenero = $genero->value;
                        $seleccionado = old('genero', $usuario->genero ?? '') == $valorGenero ? 'selected' : '';
                    @endphp
                    <option  value="{{ $genero->value }}" {{ $seleccionado }}>
                        {{ strtoupper($genero->value) }}
                    </option>
                @endforeach
            </select>
        </div>

        @if (  !isset($usuario) || ( isset($usuario) && !$usuario->esSuperAdministrador())) 
            <div class="mb-3">
                <label for="contrasenia" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasenia" name="contrasenia" {{ isset($usuario) ? '' : 'required' }}>
            </div>

            <div class="mb-3">
                <label for="contrasenia_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="contrasenia_confirmation" name="contrasenia_confirmation" {{ isset($usuario) ? '' : 'required' }}>
            </div>

            @if (isset($usuario))
                <div class="mb-3">
                    <label for="estado" class="form-label">Cambiar estado</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($usuario->getEstadosValidos() as $estado)
                            @php
                                $valorEstado = $estado->value;
                                $seleccionado = old('estado', $usuario->estado ?? '') == $valorEstado ? 'selected' : '';
                            @endphp
                            <option  value="{{ $estado->value }}"  {{ $seleccionado }} >
                                {{ strtoupper($estado->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        @endif

        <button type="submit" class="btn btn-primary">{{ isset($usuario) ? 'Actualizar Usuario' : 'Crear Usuario' }}</button>
        <a href="{{ route('usuarios.index')}}" class="btn btn-danger">Cancelar</a>
    </form>
</div>
@endsection