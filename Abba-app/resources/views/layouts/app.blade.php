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


    <link rel="stylesheet" href="{{ asset('css/aspecto.css') }}">


    {{-- Iconos de Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const aspecto = localStorage.getItem('aspecto') || 'aspecto-claro';
            document.body.classList.add(aspecto);
        });
    </script>

</head>

<body class=" ">
    {{-- 🌐 Navbar completa --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/AbbaShoes Negative.svg') }}" alt="Logo" style="height: 30px;" class="me-2">
            Gestor
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAbba">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAbba">
            {{-- Menú principal --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Productos --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-box-seam me-1"></i> Productos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('productos.index') }}">Listado</a></li>
                        <li><a class="dropdown-item" href="{{ route('productos.create') }}">Agregar</a></li>
                        <li><a class="dropdown-item" href="{{ route('productos.eliminados') }}">Eliminados</a></li>
                    </ul>
                </li>

                {{-- Clientes --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-people-fill me-1"></i> Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Listado</a></li>
                        <li><a class="dropdown-item" href="{{ route('clientes.create') }}">Agregar</a></li>
                        <li><a class="dropdown-item" href="{{ route('clientes.eliminados') }}">Eliminados</a></li>
                        <li><a class="dropdown-item" href="{{ route('clientes.historial') }}">Historial</a></li>
                    </ul>
                </li>

                {{-- Ventas --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-cart-fill me-1"></i> Ventas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('ventas.index') }}">Listado</a></li>
                        <li><a class="dropdown-item" href="{{ route('ventas.create') }}">Nueva venta</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-primary" href="{{ route('devoluciones.index') }}">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Ver devoluciones
                        </a></li>
                    </ul>
                </li>

                {{-- Gestión --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-gear-fill me-1"></i> Gestión
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('cuotas.index') }}">Cuentas por cobrar</a></li>
                        <li><a class="dropdown-item" href="{{ route('talles.index') }}">Talles</a></li>
                        <li><a class="dropdown-item" href="{{ route('reportes.index') }}">
                            <i class="bi bi-bar-chart-fill me-1"></i> Reportes</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('gastos.index') }}">Gastos</a></li>
                        <li><a class="dropdown-item" href="{{ route('gastos.create') }}">Registrar gasto</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('cierres.index') }}">Cierres de caja</a></li>
                        <li><a class="dropdown-item" href="{{ route('cierres.create') }}">Nuevo cierre</a></li>
                    </ul>
                </li>

                {{-- Selector de aspecto --}}
                
            </ul>

            {{-- Fecha actual --}}
            <ul class="navbar-nav ms-auto align-items-center me-3">
                <li class="nav-item text-white small d-flex align-items-center">
                    <i class="bi bi-clock me-1"></i> {{ now()->format('d/m/Y') }}
                </li>
            </ul>

            {{-- Salida --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="bi bi-box-arrow-right me-1"></i> Salir
                    </a>
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