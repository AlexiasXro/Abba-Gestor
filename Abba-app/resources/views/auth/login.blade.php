@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    
                    {{-- Logo o título --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="60" class="mb-3">
                        <h4 class="fw-bold text-dark">Iniciar Sesión</h4>
                        <p class="text-muted small">Accedé a tu cuenta para continuar</p>
                    </div>

                    {{-- Mensajes de error o éxito --}}
                    @if(session('error'))
                        <div class="alert alert-danger small">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success small">{{ session('success') }}</div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Correo electrónico</label>
                            <input type="email" 
                                   class="form-control form-control-sm rounded-3 @error('email') is-invalid @enderror"
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
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

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">
                                    Recordarme
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                         {{-- Botón con gradiente --}}
                        <button type="submit" class="btn btn-gradient w-100 rounded-3 fw-semibold">
                            Ingresar
                        </button>
                    </form>

                    {{-- Separador opcional --}}
                    <div class="text-center my-3 text-muted small">— o —</div>

                    {{-- Registro opcional --}}
                    <div class="text-center">
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                            Crear nueva cuenta
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
