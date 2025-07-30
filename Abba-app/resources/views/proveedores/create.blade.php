@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Nuevo Proveedor</h4>

    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        @include('proveedores._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection