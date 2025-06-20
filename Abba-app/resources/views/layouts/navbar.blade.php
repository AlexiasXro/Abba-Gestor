<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/panel') }}">🥿 ABBA</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAbba">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAbba">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Gestión de productos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuProductos" role="button" data-bs-toggle="dropdown">
                        Productos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('productos.index') }}">Listado</a></li>
                        <li><a class="dropdown-item" href="{{ route('productos.create') }}">Agregar nuevo</a></li>
                    </ul>
                </li>

                <!-- Clientes -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                </li>

                <!-- Ventas -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ventas.index') }}">Ventas</a>
                </li>

                <!-- Reportes o alertas -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('alertas.stock') }}">Stock Bajo</a>
                </li>

            </ul>

            <!-- Usuario / cerrar sesión -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Salir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
