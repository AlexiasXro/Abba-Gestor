@extends('layouts.app')

@section('content')
    <h4>Listado de Compras</h4>
    <a href="{{ route('compras.create') }}" class="btn btn-primary mb-3">Registrar Compra</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Método de Pago</th>
                 <th>Total estimado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $compra->proveedor->nombre }}</td>
                    <td>{{ $compra->metodo_pago }}</td>
                    <td>
                        ${{ number_format($compra->detalles->sum(fn($d) => $d->cantidad * $d->precio_unitario), 2) }}
                    </td>
                    <td>
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-primary btn-sm">
                            Ver detalles
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No se encontraron compras.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $compras->links() }}
@endsection
