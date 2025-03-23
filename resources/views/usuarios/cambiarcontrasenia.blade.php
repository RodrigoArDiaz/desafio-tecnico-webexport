@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center mb-4">
            <h1>Cambiar Contraseña</h1>
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

        <form action="{{  route('confirmar-cambiar-contrasenia', Auth::user()->id) }}" method="POST">
            @csrf {{-- Protección contra ataques CSRF --}}

            @method('PUT') {{-- Método HTTP para actualización --}}
            
            <label for="contrasenia_actual" class="form-label">Contraseña Actual</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="contrasenia_actual" name="contrasenia_actual" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleContraseniaActual">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <label for="contrasenia" class="form-label">Nueva Contraseña</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleContrasenia">
                    <i class="bi bi-eye"></i> 
                </button>
            </div>

            <label for="contrasenia_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="contrasenia_confirmation" name="contrasenia_confirmation" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleContraseniaConfirmar">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
        </form>
    </div>

    <script>
        const addEventTogglePassword = (idButtonToggle, idInput) => {
            document.getElementById(idButtonToggle).addEventListener('click', function () {
                const passwordInput = document.getElementById(idInput);
                const icon = this.querySelector('i');
    
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
        addEventTogglePassword('toggleContraseniaActual', 'contrasenia_actual');
        addEventTogglePassword('toggleContrasenia', 'contrasenia');
        addEventTogglePassword('toggleContraseniaConfirmar', 'contrasenia_confirmation');
    </script>
@endsection


