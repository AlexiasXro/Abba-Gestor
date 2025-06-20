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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Tienda</a>
        </div>
    </nav>

    <div class="container">

        {{-- 🔔 Alerta de stock mínimo --}}
        @php
            use App\Models\ProductoTalle;
            $productosBajoStock = ProductoTalle::with(['producto', 'talle'])
                ->where('stock', '<=', 3)
                ->get();
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

    <!-- Bootstrap JS (necesario para dismissible alert) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
