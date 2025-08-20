

@extends('layouts.app')

@section('title', 'Detalle de Talle')

@section('content')

<x-header-bar
    title="Detalle de Talle"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('talles.index'), 'class' => 'btn-secondary']
    ]"
/>

<!--Abba-app\resources\views\talles\show.blade.php 
(opcional)
-->
    <h4>📏 Detalle del Talle</h4>

    <p><strong>ID:</strong> {{ $talle->id }}</p>
    <p><strong>Talle:</strong> {{ $talle->talle }}</p>

    <a href="{{ route('talles.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    <a href="{{ route('talles.edit', $talle) }}" class="btn btn-warning">✏️ Editar</a>
@endsection
