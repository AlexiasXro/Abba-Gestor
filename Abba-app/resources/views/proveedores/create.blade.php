@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Proveedor</h1>

    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        @include('proveedores._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection