@extends('auth.layout_base')

@section('title', 'Registro')

@section('content')
<!-- Abba-app\resources\views\auth\register.blade.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Logo o título --}}
                    <div class="text-center mb-4">
                       <img src="{{ asset('images/AbbaShoes Positive.svg') }}" alt="Logo" width="60" class="mb-3">

                        <h4 class="fw-bold text-dark">Crear Cuenta</h4>
                        <p class="text-muted small">Completá tus datos para registrarte</p>
                    </div>

                    {{-- Mensajes de error --}}
                    @if($errors->any())
                        <div class="alert alert-danger small">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Formulario de registro --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small">Nombre completo</label>
                            <input type="text" 
                                   class="form-control form-control-sm rounded-3 @error('name') is-invalid @enderror"
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Correo electrónico</label>
                            <input type="email" 
                                   class="form-control form-control-sm rounded-3 @error('email') is-invalid @enderror"
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small">Contraseña</label>
                            <input type="password" 
                                   class="form-control form-control-sm rounded-3 @error('password') is-invalid @enderror"
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold small">Confirmar contraseña</label>
                            <input type="password" 
                                   class="form-control form-control-sm rounded-3"
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label fw-semibold small">Tipo de usuario</label>
                            <select name="tipo_usuario" id="tipo_usuario" 
                                    class="form-select form-select-sm rounded-3 @error('tipo_usuario') is-invalid @enderror"
                                    required>
                                <option value="">Seleccionar</option>
                                <option value="Administrador A" {{ old('tipo_usuario') == 'Administrador A' ? 'selected' : '' }}>Administrador A</option>
                                <option value="Administrador B" {{ old('tipo_usuario') == 'Administrador B' ? 'selected' : '' }}>Administrador B</option>
                                <option value="Vendedor" {{ old('tipo_usuario') == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                            </select>
                            @error('tipo_usuario')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Botón con gradiente --}}
                        <button type="submit" class="btn btn-gradient w-100 rounded-3 fw-semibold">
                            Registrarse
                        </button>
                    </form>

                    {{-- Separador opcional --}}
                    <div class="text-center my-3 text-muted small">— o —</div>

                    {{-- Ir al login --}}
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                            Iniciar sesión
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilo del gradiente --}}
@push('styles')
<style>
    .btn-gradient {
        background: linear-gradient(90deg, #6f42c1, #0d6efd);
        color: #fff;
        border: none;
        transition: opacity 0.3s ease-in-out;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        color: #fff;
    }
</style>
@endpush
@endsection
