

@extends('layouts.app')

@section('title', 'Editar Talle')

@section('content')

<!--Abba-app\resources\views\talles\edit.blade.php 
– Formulario de edición
-->
    <h4>✏️ Editar Talle</h4>

    <form action="{{ route('talles.update', $talle) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="talle" class="form-label">Talle</label>
            <input type="text" name="talle" id="talle" class="form-control" value="{{ old('talle', $talle->talle) }}" required>
            @error('talle')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('talles.index') }}" class="btn btn-secondary">⬅️ Volver</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
@endsection
