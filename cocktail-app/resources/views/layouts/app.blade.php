<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - @yield('title', 'Inicio')</title>
    <link rel="stylesheet" href="{{ asset('styles/layout/sidebar.loyaut.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>

<body>
    <div class="d-flex">
        @auth
        <div class="sidebar p-3 border-end">
            <h4 class="mb-4">Mi panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt fa-icon"></i>
                        <span class="label ms-2">Resumen</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('cocktails*') ? 'active' : '' }}" href="{{ route('cocktails.index') }}">
                        <i class="fas fa-cocktail fa-icon"></i>
                        <span class="label ms-2">Cócteles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('favorites') ? 'active' : '' }}" href="{{ route('favorites.index') }}">
                        <i class="fas fa-heart fa-icon"></i>
                        <span class="label ms-2">Mis favoritos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('perfil*') ? 'active' : '' }}" href="{{ route('perfil.edit') }}">
                        <i class="fas fa-user fa-icon"></i>
                        <span class="label ms-2">Mi perfil</span>
                    </a>
                </li>

                @if(auth()->user()->role_id === 1)
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                        <i class="fas fa-users fa-icon"></i>
                        <span class="label ms-2">Panel de usuarios</span>
                    </a>
                </li>
                @endif

                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span class="label">Cerrar sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>