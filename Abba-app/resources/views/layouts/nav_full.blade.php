{{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-xl bg-dark shadow-xl">

        <div class="container ">
            <!-- LOGO -->
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/panel') }}">
                <img src="{{ asset('images/AbbaShoes Negative.svg') }}" alt="Logo" style="height: 30px" class="me-2" />
                Gestor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAbba">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAbba">
                {{-- Menú principal --}}
                <ul class="navbar-nav me-auto mb-1 mb-lg-0 ms-auto align-items-center me-3 ">

                    {{-- Productos --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-box-seam me-1"></i> Productos
                        </a>
                        <ul class="dropdown-menu custom-hover">
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
                        <ul class="dropdown-menu custom-hover">
                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Listado</a></li>
                            <li><a class="dropdown-item" href="{{ route('clientes.create') }}">Agregar</a></li>
                            <li><a class="dropdown-item" href="{{ route('clientes.eliminados') }}">Eliminados</a></li>
                            <li><a class="dropdown-item" href="{{ route('clientes.historial') }}">Historial</a></li>
                        </ul>
                    </li>

                    {{-- Ventas --}}
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-cart-fill me-1"></i> Ventas
                        </a>


                        <ul class="dropdown-menu custom-hover">
                            <li><a class="dropdown-item" href="{{ route('ventas.index') }}">Listado</a></li>
                            <li><a class="dropdown-item" href="{{ route('ventas.create') }}">Nueva venta</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item text-primary" href="{{ route('devoluciones.index') }}">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Ver devoluciones
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{-- Inventario --}}
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            Inventario
                        </a>
                        <ul class="dropdown-menu custom-hover">
                            <li><a class="dropdown-item" href="{{ route('talles.index') }}">Talles</a></li>
                            <li><a class="dropdown-item" href="{{ route('categorias.index') }}">Categorías</a></li>
                            <li><a class="dropdown-item" href="{{ route('compras.index') }}">Compras</a></li>
                            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Proveedores</a></li>
                        </ul>
                    </li>
                    {{-- ADMInistracion --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-briefcase-fill me-1"></i> Administración
                        </a>
                        <ul class="dropdown-menu custom-hover">
                            <li><a class="dropdown-item" href="{{ route('cuotas.index') }}">Cuentas por cobrar</a></li>
                            <li><a class="dropdown-item" href="{{ route('reportes.index') }}"><i
                                        class="bi bi-bar-chart-fill me-1"></i> Reportes</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="{{ route('gastos.index') }}">Gastos</a></li>
                            <li><a class="dropdown-item" href="{{ route('gastos.create') }}">Registrar gasto</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="{{ route('cierres.index') }}">Cierres de caja</a></li>
                            <li><a class="dropdown-item" href="{{ route('cierres.create') }}">Nuevo cierre</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="{{ route('configuracion.margenes') }}">Márgenes de
                                    Precios</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('scanner.index') }}">
                            <i class="bi bi-qr-code-scan fs-4 me-1"></i> Escáner
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
                        <a class="nav-link position-relative" href="#" id="alertaStockDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" aria-label="Alertas de stock bajo">
                            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 1.2rem"></i>
                            @if ($cantidadAlertas > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cantidadAlertas }}
                                    <span class="visually-hidden">productos con stock bajo</span>
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="alertaStockDropdown" style="
                                min-width: 300px;
                                max-height: 300px;
                                overflow-y: auto;
                                background-color: #212529;
                                color: white;
                            ">
                            <li>
                                <strong class="text-warning">⚠ {{ $cantidadAlertas }} producto(s) con stock
                                    bajo</strong>
                            </li>
                            <hr class="my-1" />
                            @forelse ($productosBajoStock as $productoId => $items)
                                <li class="mb-2">
                                    <div>
                                        <strong>{{ optional($items->first()->producto)->nombre ?? 'Producto eliminado' }}</strong>
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


                {{-- Salida --}}
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Salir</button>
                        </form>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- Navbar fin --}}