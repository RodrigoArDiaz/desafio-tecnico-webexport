@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9">
                <div class="card">
                    <div class="card-header bg-dark text-white text-center fs-4">
                       ¡Bienvenido!
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mx-3 my-5">
                                <div class="mb-3">
                                    <label for="mail" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="mail" name="mail" required>
                                </div>
                                <label for="contrasenia" class="form-label">Contraseña</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i> <!-- Ícono de ojo (usando Bootstrap Icons) -->
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center px-3 my-5">
                                <button type="submit" class="btn btn-dark w-100">Iniciar Sesión</button>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger m-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    addEventTogglePassword('togglePassword', 'contrasenia');
</script>
@endsection
