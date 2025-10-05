@extends('layouts.app')

@section('content')
<div class="container mt-3">
<x-header-bar
    title="Nuevo Proveedor"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('proveedores.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="max-width: 720px; width: 100%;">
            <h5 class="mb-3"><i class="bi bi-person-plus-fill"></i> Nuevo Proveedor</h5>

            <form action="{{ route('proveedores.store') }}" method="POST">
                @csrf

                @include('proveedores._form')

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Guardar
                    </button>
                    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection