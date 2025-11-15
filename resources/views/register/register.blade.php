@extends('layouts.app')

@section('title', 'Registro - Sistema Educativo')

@section('content')
    <div class="register-container">
        <!-- Left Panel - Informativo -->
        <div class="register-info-panel">
            <div class="info-content">
                <div class="info-header">
                    <i class="fas fa-graduation-cap"></i>
                    <h1>AcademicSoftware</h1>
                </div>

                <div class="info-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Gestión Académica</h4>
                            <p>Control completo de calificaciones y notas</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Reportes Inteligentes</h4>
                            <p>Análisis detallado del desempeño estudiantil</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Comunicación Efectiva</h4>
                            <p>Conecta padres, estudiantes y maestros</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Seguridad Garantizada</h4>
                            <p>Tus datos protegidos con tecnología avanzada</p>
                        </div>
                    </div>
                </div>

                <div class="info-footer">
                    <p>Únete a la revolución educativa digital</p>
                </div>
            </div>
        </div>

        <!-- Right Panel - Formulario -->
        <div class="register-form-panel">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Crear Cuenta</h2>
                    <p>Completa el formulario para comenzar</p>
                </div>

                @if ($errors->any())
                    <div class="register-alert register-alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Error en el registro</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf

                    <!-- Nombre -->
                    <div class="form-group-register">
                        <label for="name">Nombre Completo</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                placeholder="Juan Pérez"
                                class="@error('name') input-error @enderror"
                            >
                        </div>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group-register">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                placeholder="tu@email.com"
                                class="@error('email') input-error @enderror"
                            >
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group-register">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                placeholder="••••••••"
                                class="@error('password') input-error @enderror"
                            >
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar"></div>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="form-group-register">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                placeholder="••••••••"
                                class="@error('password_confirmation') input-error @enderror"
                            >
                        </div>
                        @error('password_confirmation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-register-submit">
                        <span>Crear Cuenta</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="form-footer">
                    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthBar = document.querySelector('.strength-bar');

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                strengthBar.style.width = strength + '%';
                
                if (strength < 33) {
                    strengthBar.style.backgroundColor = '#ef4444';
                } else if (strength < 66) {
                    strengthBar.style.backgroundColor = '#f59e0b';
                } else {
                    strengthBar.style.backgroundColor = '#10b981';
                }
            });
        }

        function calculatePasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 10;
            if (/[a-z]/.test(password)) strength += 15;
            if (/[A-Z]/.test(password)) strength += 15;
            if (/[0-9]/.test(password)) strength += 15;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 20;
            
            return Math.min(strength, 100);
        }
    </script>
@endsection
