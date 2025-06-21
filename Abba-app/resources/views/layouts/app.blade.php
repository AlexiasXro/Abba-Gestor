<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    {{-- 🌐 Navbar completa --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/panel') }}">🥿 Mi Tienda</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAbba">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAbba">
                <ul class="navbar-nav me-auto">



                    {{-- Productos --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Productos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('productos.index') }}">Listado</a></li>
                            <li><a class="dropdown-item" href="{{ route('productos.create') }}">Agregar</a></li>
                            <li><a class="dropdown-item" href="{{ route('productos.eliminados') }}">Eliminados</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Stock por talles</a></li>
                        </ul>
                    </li>

                    {{-- Clientes --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Clientes</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Listado</a></li>
                            <li><a class="dropdown-item" href="{{ route('clientes.create') }}">Agregar</a></li>
                            <li><a class="dropdown-item" href="{{ route('clientes.eliminados') }}">Eliminados</a></li>
                        </ul>
                    </li>

                    {{-- Ventas --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Ventas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('productos.index') }}">Historial</a></li>
                            <li><a class="dropdown-item" href="{{ route('ventas.create') }}">Nueva venta</a></li>
                            <li><a class="dropdown-item" href="#">Ticket PDF</a></li>
                        </ul>
                    </li>

                    {{-- Alertas y reportes --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">Stock Bajo</a>
                    </li>

                    {{-- Admin / Configuración futura --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Configuración</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('talles.index') }}">Talles</a></li>
                            <li><a class="dropdown-item" href="#">Usuarios (futuro)</a></li>
                        </ul>
                    </li>

                </ul>

                {{-- Cierre de sesión u otro menú --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        {{-- 🔔 Alerta de stock mínimo --}}
        @php
        use App\Models\ProductoTalle;
        $productosBajoStock = ProductoTalle::with(['producto', 'talle'])
        ->where('stock', '<=', 3) ->get();
            @endphp

            @if($productosBajoStock->isNotEmpty())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5>⚠️ Productos con stock bajo (≤ 3 unidades):</h5>
                <ul class="mb-0">
                    @foreach($productosBajoStock as $item)
                    <li>
                        {{ $item->producto->nombre }} - Talle: {{ $item->talle->talle }}
                        (Stock: {{ $item->stock }})
                    </li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
            @endif

            {{-- Contenido dinámico de cada vista --}}
            @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>