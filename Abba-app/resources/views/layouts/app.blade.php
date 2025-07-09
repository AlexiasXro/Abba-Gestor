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
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark mb-4 no-print">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/AbbaShoes Negative.svg') }}" alt="Logo" style="height: 30px;">
                Gestor</a>
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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownAspecto" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Aspecto del sistema
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAspecto"
                            style="min-width: 200px;">
                            <li>
                                <select id="selector-aspecto" class="form-select form-select-sm mx-3 my-2" style="width: calc(100% - 1.5rem);">
                                    <option value="aspecto-claro">Claro clásico</option>
                                    <option value="aspecto-oscuro">Oscuro moderno</option>
                                    <option value="aspecto-celeste">Celeste profesional</option>
                                    <option value="aspecto-beige">Beige natural</option>
                                    <option value="aspecto-rosado">Rosa pastel</option>
                                    <option value="aspecto-oliva">Verde oliva</option>
                                    <option value="aspecto-gris">Gris minimalista</option>
                                    <option value="aspecto-azul-marino">Azul marino</option>
                                    <option value="aspecto-naranja">Naranja vibrante</option>
                                    <option value="aspecto-morado">Morado suave</option>
                                    <option value="aspecto-amarillo">Amarillo claro</option>
                                    <option value="aspecto-rojo">Rojo suave</option>
                                    <option value="aspecto-gris-oscuro">Gris oscuro</option>
                                </select>
                            </li>
                        </ul>
                    </li>

                    <script>
                        const selector = document.getElementById('selector-aspecto');
                        const aspectos = [
                            'aspecto-claro', 'aspecto-oscuro', 'aspecto-celeste', 'aspecto-beige',
                            'aspecto-rosado', 'aspecto-oliva', 'aspecto-gris', 'aspecto-azul-marino',
                            'aspecto-naranja', 'aspecto-morado', 'aspecto-amarillo', 'aspecto-rojo',
                            'aspecto-gris-oscuro'
                        ];

                        // Cargar clase desde localStorage o usar 'aspecto-claro' por defecto
                        const actual = localStorage.getItem('aspecto') || 'aspecto-claro';
                        document.body.classList.add(actual);
                        selector.value = actual;

                        selector.addEventListener('change', function () {
                            const nuevo = this.value;

                            // Quitar todas las clases anteriores
                            document.body.classList.remove(...aspectos);
                            // Agregar la nueva clase
                            document.body.classList.add(nuevo);
                            // Guardar en localStorage
                            localStorage.setItem('aspecto', nuevo);
                        });
                    </script>


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