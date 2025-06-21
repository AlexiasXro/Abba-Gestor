

@extends('layouts.app')

@section('title', 'Detalle de Talle')

@section('content')

<!--Abba-app\resources\views\talles\show.blade.php 
(opcional)
-->
    <h2>📏 Detalle del Talle</h2>

    <p><strong>ID:</strong> {{ $talle->id }}</p>
    <p><strong>Talle:</strong> {{ $talle->talle }}</p>

    <a href="{{ route('talles.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    <a href="{{ route('talles.edit', $talle) }}" class="btn btn-warning">✏️ Editar</a>
@endsection
