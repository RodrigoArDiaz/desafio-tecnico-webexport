@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Productos</h1>
            {{-- Tiene permiso de creacion --}}
            @can('crear_productos')
                <a href="#" class="btn btn-success">Crear Nuevo Producto</a>
            @endcan
        </div>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Producto 1</h5>
                <p class="card-text">Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Nobis sed tempore
                    corporis obcaecati aliquid odio, omnis facere commodi
                    voluptates hic temporibus neque at possimus non rem laborum
                    quibusdam praesentium perferendis!</p>
                {{-- Tiene permiso de edicion --}}
                @can('editar_productos')
                    <a href="#" class="btn btn-primary">Editar</a>
                @endcan
                {{-- Tiene permiso de eliminacion --}}
                @can('eliminar_productos')
                    <a href="#" class="btn btn-danger">Eliminar</a>
                @endcan
            </div>
        </div>
    </div>
@endsection
