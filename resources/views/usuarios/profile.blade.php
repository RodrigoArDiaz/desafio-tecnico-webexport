@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center mb-4">
            <h1>Mi Perfil</h1>
            @if (Auth::user()->esSuperAdministrador())
                 <span class="badge text-bg-success mx-4">Superadministrador</span>
            @endif
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form>
            @php
                $usuario = Auth::user();
            @endphp
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control " id="nombre" name="nombre" value="{{ $usuario->nombre}}" readonly>
                </div>
        
                <div class="mb-3 col-6">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $usuario->apellido }}" readonly>
                </div>
            </div>
            
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="{{ $usuario->dni }}" readonly>
                </div>
        
                <div class="mb-3 col-6">
                    <label for="mail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail" value="{{  $usuario->mail }}" readonly>
                </div>
            </div>
            
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="fecha_de_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_de_nacimiento" name="fecha_de_nacimiento" value="{{  $usuario->fecha_de_nacimiento  }}" readonly>
                </div>

                <div class="mb-3 col-6">
                    <label for="genero" class="form-label">Genero</label>
                    <input type="text" class="form-control" id="genero" name="genero" value="{{  $usuario->genero }}" readonly>
                </div>
            </div>
        </form>

        <div class="row mt-4">
            <div class="col-6">
            <a href="{{ route('cambiar-contrasenia',$usuario->id )}}" class="btn btn-primary">Cambiar Contraseña</a>
            </div>
        </div>
    </div>
@endsection


