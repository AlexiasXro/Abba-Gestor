<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Panel de Control')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- htmx -->
    <script src="https://unpkg.com/htmx.org@1.9.2"></script>

    <link rel="stylesheet" href="{{ asset('css/aspecto.css') }}" />

    {{-- Iconos Bootstrap --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const aspecto = localStorage.getItem("aspecto") || "aspecto-claro";
            document.body.classList.add(aspecto);
        });
    </script>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-xl">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img
                    src="{{ asset('images/AbbaShoes Negative.svg') }}"
                    alt="Logo"
                    style="height: 30px"
                    class="me-2"
                />
                Gestor
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarAbba"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAbba">
                {{-- Menú principal --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- Productos --}}
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
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
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
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
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            <i class="bi bi-cart-fill me-1"></i> Ventas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('ventas.index') }}">Listado</a></li>
                            <li><a class="dropdown-item" href="{{ route('ventas.create') }}">Nueva venta</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a
                                    class="dropdown-item text-primary"
                                    href="{{ route('devoluciones.index') }}"
                                >
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Ver devoluciones
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Gestión --}}
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            <i class="bi bi-gear-fill me-1"></i> Gestión
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('cuotas.index') }}">Cuentas por cobrar</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('reportes.index') }}">
                                    <i class="bi bi-bar-chart-fill me-1"></i> Reportes
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ route('gastos.index') }}">Gastos</a></li>
                            <li><a class="dropdown-item" href="{{ route('gastos.create') }}">Registrar gasto</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ route('cierres.index') }}">Cierres de caja</a></li>
                            <li><a class="dropdown-item" href="{{ route('cierres.create') }}">Nuevo cierre</a></li>
                        </ul>
                    </li>

                    {{-- Inventario --}}
                    <li class="nav-item dropdown">
                        <a
                            href="#"
                            class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                        >
                            Inventario
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('talles.index') }}">Talles</a></li>
                            <li><a class="dropdown-item" href="{{ route('compras.index') }}">Compras</a></li>
                            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Proveedores</a></li>
                        </ul>
                    </li>

                    {{-- Margenes de precios --}}
                    <li class="nav-item">
                        <a
                            href="{{ route('configuracion.margenes') }}"
                            class="text-sm text-gray-800 hover:text-blue-600 nav-link"
                        >
                            Márgenes de Precios
                        </a>
                    </li>

                    {{-- Alerta Stock Bajo --}}
                    @php
use App\Models\ProductoTalle;

$productosBajoStock = ProductoTalle::with(['producto', 'talle'])
    ->where('stock', '<=', 1)
    ->orderBy('stock')
    ->get()
    ->groupBy('producto_id');

$cantidadAlertas = $productosBajoStock->count();
                    @endphp
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link position-relative"
                            href="#"
                            id="alertaStockDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-label="Alertas de stock bajo"
                        >
                            <i
                                class="bi bi-exclamation-triangle-fill text-warning"
                                style="font-size: 1.2rem"
                            ></i>
                            @if ($cantidadAlertas > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                >
                                    {{ $cantidadAlertas }}
                                    <span class="visually-hidden">productos con stock bajo</span>
                                </span>
                            @endif
                        </a>
                        <ul
                            class="dropdown-menu dropdown-menu-end p-3"
                            aria-labelledby="alertaStockDropdown"
                            style="
                                min-width: 300px;
                                max-height: 300px;
                                overflow-y: auto;
                                background-color: #212529;
                                color: white;
                            "
                        >
                            <li>
                                <strong class="text-warning"
                                    >⚠ {{ $cantidadAlertas }} producto(s) con stock bajo</strong
                                >
                            </li>
                            <hr class="my-1" />
                            @forelse ($productosBajoStock as $productoId => $items)
                                <li class="mb-2">
                                    <div>
                                        <strong
                                            >{{ optional($items->first()->producto)->nombre ?? 'Producto eliminado' }}</strong
                                        >
                                    </div>
                                    <ul class="mb-0 ps-3 small">
                                        @foreach ($items as $item)
                                            <li>
                                                Talle {{ $item->talle->talle }} —
                                                <span class="text-danger fw-bold">{{ $item->stock }}</span>
                                                unidad(es)
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @empty
                                <li>No hay productos con stock bajo.</li>
                            @endforelse
                        </ul>
                    </li>
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
    {{-- Navbar fin --}}


    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    
    @if(session('warning'))
        <x-alert type="warning" :message="session('warning')" />
    @endif
    
    @if(session('info'))
        <x-alert type="info" :message="session('info')" />
    @endif


    {{-- Contenedor principal --}}
    <div class="container">
        {{-- Contenido dinámico --}}
        @yield('content')
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
