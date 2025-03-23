@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Roles</h2>

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

    <form action="{{ route('usuarios.update_roles', $usuario->id) }}" method="POST">
        @csrf {{-- Protección contra ataques CSRF --}}

        {{-- @if (isset($usuario))
            @method('PUT') 
        @endif --}}

        <div class="mb-3">
            <p class="h4">{{$usuario->nombre }} {{$usuario->apellido}}</p>
        </div>

        <div class="list-group mb-3">
            @php
                $rolesDelUsuario =  isset($usuario) ? $usuario->getRolesIds() : [];
            @endphp
            @foreach($roles as $rol)
                <label class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input 
                            class="form-check-input me-2" 
                            type="checkbox" 
                            name="roles[]" 
                            value="{{ $rol->id }}"
                            {{ in_array($rol->id, $rolesDelUsuario) ? 'checked' : '' }}
                        >
                        <span>{{ $rol->nombre }}</span>
                    </div>

                    <div>
                        <button 
                        type="button" 
                        class="btn btn-secondary btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalRol{{ $rol->id }}"
                        >
                            Ver permisos
                        </button>
                    </div>
                </label>

                 <!-- Modal para cada rol -->
                <div class="modal fade" id="modalRol{{ $rol->id }}" tabindex="-1" aria-labelledby="modalRolLabel{{ $rol->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalRolLabel{{ $rol->id }}">Permisos del Rol: {{ $rol->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="list-group mb-3">
                                    @php
                                        $permisosDelRol = $rol->getPermisosNombres();
                                    @endphp
                                    @foreach($permisosDelRol as $permiso)
                                    <label class="list-group-item">  {{ $permiso }} </label>
                                    @endforeach
                                    @if (count($permisosDelRol) == 0)
                                        <div class="alert alert-danger" role="alert">
                                            El rol no tiene permisos asociados.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
             @endforeach
                
            @if (count($roles) == 0)
              <div class="alert alert-danger" role="alert">
                No hay roles disponibles
              </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($usuario) ? 'Actualizar Usuario' : 'Crear Usuario' }}</button>
        <a href="{{ route('usuarios.index')}}" class="btn btn-danger">Cancelar</a>
    </form>
</div>

@endsection

