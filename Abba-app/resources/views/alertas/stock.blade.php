<h2>Productos con stock bajo por talle</h2>

@forelse ($productos as $producto)
    <h4>{{ $producto->nombre }} (Stock mínimo: {{ $producto->stock_minimo }})</h4>
    <ul>
        @foreach ($producto->talles as $talle)
            <li>
                Talle: {{ $talle->talle }} - Stock actual: {{ $talle->pivot->stock }}
            </li>
        @endforeach
    </ul>
@empty
    <p>No hay productos con stock bajo.</p>
@endforelse