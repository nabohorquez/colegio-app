@extends('layouts.app')

@section('title', 'Iniciar Sesión - Sistema Escolar')

@section('content')
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-card">
                <!-- Header -->
                <div class="login-header">
                    <div class="school-logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h1>Mi Colegio</h1>
                    <p class="subtitle">Sistema de Gestión Educativa Integral</p>
                </div>

                <!-- Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><strong>Error de autenticación</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login.post') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror"
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                            autofocus
                            placeholder="tu@colegio.com"
                        >
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror"
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="remember" 
                            name="remember"
                        >
                        <label class="form-check-label" for="remember">
                            <i class="fas fa-check me-1"></i>Recordarme en este navegador
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    <p>¿No tienes cuenta? <a href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i>Solicita una aquí</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
