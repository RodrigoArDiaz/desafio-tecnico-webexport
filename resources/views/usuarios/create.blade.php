@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Usuario</h2>

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

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf {{-- Protección contra ataques CSRF --}}

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}">
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
        </div>

        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni') }}" required>
        </div>

        <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" value="{{ old('mail') }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha_de_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_de_nacimiento" name="fecha_de_nacimiento" value="{{ old('fecha_de_nacimiento') }}" required>
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Género</label>

            <select class="form-control" id="genero" name="genero" required>
                <option value="">Seleccione una opción</option>
                @foreach($generos as $genero)
                    <option  value="{{ $genero->value }}"  {{ old('genero') == $genero->value  ? 'selected' : '' }}> {{ strtoupper($genero->value) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="contrasenia" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
        </div>

        <div class="mb-3">
            <label for="contrasenia_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="contrasenia_confirmation" name="contrasenia_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
@endsection
