

@extends('layouts.app')

@section('title', 'Nuevo Talle')

@section('content')

<!--Abba-app\resources\views\talles\create.blade.php 
– Formulario de altas
-->
    <h2>➕ Nuevo Talle</h2>

    <form action="{{ route('talles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="talle" class="form-label">Talle</label>
            <input type="text" name="talle" id="talle" class="form-control" value="{{ old('talle') }}" required>
            @error('talle')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('talles.index') }}" class="btn btn-secondary">⬅️ Volver</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
