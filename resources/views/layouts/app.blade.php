<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio tecnico WebExport</title>
    <!-- Bootstrap CSS desde jsDelivr -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-body px-2" data-bs-theme="dark">
            <a class="navbar-brand" href="{{ route('inicio')}}">Desafío Técnico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav  ms-auto my-2 my-lg-0 navbar-nav-scroll" >
                    {{-- Rutas para comprobacion de permisos --}}
                    @can('ver_productos')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos') }}">Productos</a>
                        </li>
                    @endcan

                    @can('ver_cursos')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cursos') }}">Cursos</a>
                        </li>
                    @endcan


                    @if ( Auth::user()->esSuperAdministrador())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuarios.index') }}">CRUD Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roles.index') }}">CRUD Roles</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->nombre }} 
                        @if (Auth::user()->esSuperAdministrador())
                            (superadministrador)
                        @endif
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('perfil') }}">Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                      </ul>
                    </li>
                </ul>
            </div>
        </nav>
    @endauth

    {{-- Contenedor central --}}
    <div class="container mt-4 mb-4">
        @yield('content')
    </div>

    {{-- Scripts Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
