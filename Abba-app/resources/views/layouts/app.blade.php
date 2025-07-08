<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- htmx-->
    <script src="https://unpkg.com/htmx.org@1.9.2"></script>


</head>

<body class="bg-light">
    {{-- 🌐 Navbar completa --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 no-print">
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
                            <li><a class="dropdown-item" href="{{ route('clientes.historial') }}">Historial</a></li>
                        </ul>
                    </li>

                    {{-- Ventas --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Ventas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('ventas.index') }}">Listado</a></li>
                            <li><a class="dropdown-item" href="{{ route('ventas.create') }}">Nueva venta</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="gestionDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Gestión
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="gestionDropdown">
                            <li><a class="dropdown-item" href="{{ route('cuotas.index') }}">Cuentas por cobrar</a></li>
                            <li><a class="dropdown-item" href="{{ route('talles.index') }}">Talles</a></li>
                            <li><a class="dropdown-item" href="{{ route('reportes.index') }}">
                                    <i class="bi bi-bar-chart"></i> Reportes
                                </a></li>
                        </ul>
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
                ->where('stock', '<=', 1)->orderBy('stock')
                ->get()
                ->groupBy('producto_id');
        @endphp

        @if(isset($mostrarAlertaStock) && $mostrarAlertaStock && $productosBajoStock->isNotEmpty())
            <div class="card border-warning mb-3 shadow-sm" style="font-size: 0.9rem;">
                <div class="card-body py-2">
                    <strong class="text-warning">
                        ⚠ {{ $productosBajoStock->count() }} producto(s) con stock bajo
                    </strong>

                    <button class="btn btn-sm btn-outline-warning float-end" type="button" data-bs-toggle="collapse"
                        data-bs-target="#alertaStockCollapse">
                        Ver detalles
                    </button>
                    <div class="clearfix"></div>

                    <div class="collapse mt-2" id="alertaStockCollapse">
                        @foreach ($productosBajoStock as $productoId => $items)
                            <strong class="d-block mt-2">
                                {{ optional($items->first()->producto)->nombre ?? 'Producto eliminado' }}
                            </strong>
                            <ul class="mb-2 ps-3">
                                @foreach ($items as $item)
                                    <li>
                                        Talle {{ $item->talle->talle }} —
                                        <span class="text-danger fw-bold">{{ $item->stock }}</span> unidad(es)
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
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