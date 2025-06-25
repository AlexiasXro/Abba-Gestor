<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">
    {{-- 🌐 Navbar completa --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">🌐 Mi Tienda</a>
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
                        </ul>
                    </li>

                    {{-- Configuración --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('talles.index') }}">Talles</a>
                    </li>
                </ul>

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
        ->where('stock', '<=', 3) ->orderBy('stock')
            ->get()
            ->groupBy('producto_id');
            @endphp

            @if($productosBajoStock->isNotEmpty())
            <div class="alert alert-warning">
                <strong>¡Atención!</strong> Hay productos con stock bajo.
                <button class="btn btn-sm btn-outline-dark float-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#alertaStockCollapse">
                    Ver detalles
                </button>
                <div class="clearfix"></div>

                <div class="collapse mt-3" id="alertaStockCollapse">
                    @foreach ($productosBajoStock as $productoId => $items)
                    <strong>
                        {{ optional($items->first()->producto)->nombre ?? 'Producto eliminado' }}
                    </strong>


                    <ul class="mb-2">
                        @foreach ($items as $item)
                        <li>Talle: {{ $item->talle->talle }} — Stock: {{ $item->stock }}</li>
                        @endforeach
                    </ul>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Contenido dinámico de cada vista --}}
            @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
</body>

</html>