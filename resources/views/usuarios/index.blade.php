@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Usuarios</h1>
            <a href="{{ route('usuarios.create')}}" class="btn btn-success">Crear Nuevo Usuario</a>
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
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Estado</th>
                    <th scope="col" class="text-center">Nombre</th>
                    <th scope="col" class="text-center">Apellido</th>
                    <th scope="col" class="text-center">Mail</th>
                    <th scope="col" class="text-center">DNI</th>
                    <th scope="col" class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        @php
                            switch ($usuario['estado']) {
                                case 'alta':
                                    $estadoClass = 'success';
                                    break;
                                case 'baja':
                                    $estadoClass = 'danger';
                                    break;
                                case 'suspendido':
                                    $estadoClass = 'warning';
                                    break;
                                default:
                                    $estadoClass = 'secondary';
                                    break;
                            }
                        @endphp
                        <td class="text-center">  <span class="badge text-bg-{{ $estadoClass }}">{{ strtoupper($usuario['estado']) }}</span></td>
                        <td class="text-center">{{ $usuario['nombre'] }}</td>
                        <td class="text-center">{{ $usuario['apellido'] }}</td>
                        <td class="text-center">{{ $usuario['mail'] }}</td>
                        <td class="text-center">{{ $usuario['dni'] }}</td>
                        <td class="text-center">
                            <a href="{{ route('usuarios.edit_roles', ['usuario' => $usuario->id])}}" class="btn btn-secondary btn-sm">Editar Roles</a>
                            <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id])}}" class="btn btn-success btn-sm">Editar</a>
                            <form action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
