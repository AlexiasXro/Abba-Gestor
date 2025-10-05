<x-header-bar
    title="Proveedores Eliminados"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('proveedores.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container mt-3">
    <div class="card shadow-sm p-3">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>CUIT</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->cuit }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>
                            <form action="{{ route('proveedores.restore', $proveedor->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $proveedores->links() }}
    </div>
</div>
@endsection