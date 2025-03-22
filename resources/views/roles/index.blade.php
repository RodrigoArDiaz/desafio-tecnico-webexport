@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Roles</h1>
            <a href="{{ route('roles.create')}}" class="btn btn-success">Crear Nuevo Rol</a>
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
                    <th scope="col" class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $roles)
                    <tr>
                        @php
                            switch ($roles['estado']) {
                                case 'alta':
                                    $estadoClass = 'success';
                                    break;
                                case 'baja':
                                    $estadoClass = 'danger';
                                    break;
                                default:
                                    $estadoClass = 'secondary';
                                    break;
                            }
                        @endphp
                        <td class="text-center">  <span class="badge text-bg-{{ $estadoClass }}">{{ strtoupper($roles['estado']) }}</span></td>
                        <td class="text-center">{{ $roles['nombre'] }}</td>
                        <td class="text-center">
                            {{-- <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id])}}" class="btn btn-success btn-sm">Editar</a>
                            <form action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
