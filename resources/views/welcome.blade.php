<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcademicSoftware - Sistema de Gestión Educativa</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-container {
            text-align: center;
            color: white;
            max-width: 600px;
            padding: 20px;
        }

        .school-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .welcome-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .welcome-subtitle {
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-welcome {
            padding: 12px 35px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 2px solid white;
            display: inline-block;
        }

        .btn-primary-welcome {
            background: white;
            color: #667eea;
        }

        .btn-primary-welcome:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            background: #f8f9fa;
        }

        .btn-secondary-welcome {
            background: transparent;
            color: white;
        }

        .btn-secondary-welcome:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-3px);
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 60px;
            padding: 0 20px;
        }

        .info-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .info-card-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .info-card-title {
            font-size: 14px;
            font-weight: 600;
            opacity: 0.9;
        }

        .info-card-number {
            font-size: 24px;
            font-weight: 700;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 32px;
            }

            .welcome-subtitle {
                font-size: 14px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn-welcome {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <!-- Header -->
        <div class="school-icon">
            <i class="fas fa-school"></i>
        </div>

        <h1 class="welcome-title">AcademicSoftware</h1>
        <p class="welcome-subtitle">Sistema de Gestión Educativa Minimalista</p>

        <!-- Buttons -->
        <div class="button-group">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('dashboard') }}" class="btn-welcome btn-primary-welcome">
                        <i class="fas fa-arrow-right me-2"></i>Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-welcome btn-primary-welcome">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-welcome btn-secondary-welcome">
                            <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <!-- Info Cards (opcional) -->
        @guest
        <div class="info-cards">
            <div class="info-card">
                <div class="info-card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="info-card-title">Gestión Académica</div>
                <div class="info-card-number">100%</div>
            </div>

            <div class="info-card">
                <div class="info-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="info-card-title">Estudiantes</div>
                <div class="info-card-number">+1K</div>
            </div>

            <div class="info-card">
                <div class="info-card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="info-card-title">Reportes</div>
                <div class="info-card-number">Real-time</div>
            </div>
        </div>
        @endguest
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
