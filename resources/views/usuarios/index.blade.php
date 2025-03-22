@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Usuarios</h1>
            <a href="#" class="btn btn-success">Crear Nuevo Usuario</a>
        </div>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Estado</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Mail</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario['estado'] }}</td>
                        <td>{{ $usuario['nombre'] }}</td>
                        <td>{{ $usuario['apellido'] }}</td>
                        <td>{{ $usuario['mail'] }}</td>
                        <td>{{ $usuario['dni'] }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
