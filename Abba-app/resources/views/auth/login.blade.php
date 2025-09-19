@extends('auth.layout_base')

@section('title', 'Iniciar Sesión')

@section('content')

    <!-- Abba-app\resources\views\auth\login.blade.php -->
<div class="container d-flex align-items-center min-vh-100">
    <div class="row justify-content-center align-items-center w-100 ">
        <!-- Columna formulario -->
        <div class="col-md-5 d-flex align-items-center">
                    <div class="card shadow-sm border-0 rounded-4 w-100">
                        <div class="card-body p-4">

                            {{-- Logo o título --}}
                            <div class="text-center mb-4">
                              
                       <img src="{{ asset('images/AbbaShoes Positive.svg') }}" alt="Logo" width="60" class="mb-3">

                      
                                <h4 class="fw-bold text-dark mt-2">Iniciar Sesión</h4>
                                <p class="text-muted small">Accedé a tu cuenta para continuar</p>
                            </div>

                            {{-- Mensajes de error --}}
                            @if($errors->any())
                                <div class="alert alert-danger small">
                                    @foreach($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Formulario --}}
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold small">Correo electrónico</label>
                                    <input type="email"
                                        class="form-control form-control-sm rounded-3 @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold small">Contraseña</label>
                                    <input type="password"
                                        class="form-control form-control-sm rounded-3 @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
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

                                {{-- Botón --}}
                                <button type="submit" class="btn btn-secondary w-100 rounded-3 fw-semibold">
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

        <!-- Información del sistema -->
        <div class="col-md-4 d-flex align-items-center mt-4 mt-md-0">
            <div class="info-box p-3">
                <h5 class="fw-bold">
                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                    ¿Qué es este sistema?
                </h5>
                <p class="small">
                    Este gestor está diseñado para administrar <strong>ventas, stock y clientes</strong> de tu negocio.
                    Permite registrar productos, controlar talles y cantidades, generar comprobantes de venta y
                    acceder a reportes para mejorar la gestión diaria.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection