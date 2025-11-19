<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Light Mode */
            --bg-primary: #ffffff;
            --bg-secondary: #f5f7fa;
            --bg-tertiary: #eff2f7;
            --text-primary: #1a202c;
            --text-secondary: #4a5568;
            --text-tertiary: #718096;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --sidebar-bg: #f8fafc;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
            
            /* Colors */
            --primary: #5b5bff;
            --primary-light: #7b7bff;
            --primary-dark: #3b3bdd;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;
        }

        body.dark-mode {
            --bg-primary: #0f1419;
            --bg-secondary: #1a1f2e;
            --bg-tertiary: #252d3d;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-tertiary: #94a3b8;
            --border-color: #334155;
            --card-bg: #1e293b;
            --sidebar-bg: #111827;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        /* ===== LOGIN PAGE ===== */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 50%, #001f3f 100%);
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .login-container::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 65px 45px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4), 0 0 1px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.95);
        }

        .login-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .school-logo {
            font-size: 60px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .login-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 12px 0;
            font-family: 'Poppins', sans-serif;
        }

        .login-header .subtitle {
            color: #475569;
            font-size: 15px;
            margin: 0;
            font-weight: 500;
        }

        .login-form .form-group {
            margin-bottom: 26px;
        }

        .login-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .login-form .form-control {
            height: 52px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .login-form .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: white;
            outline: none;
        }

        .login-form .form-control.is-invalid {
            border-color: #ef4444;
        }

        .login-form .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .login-form .invalid-feedback {
            font-size: 13px;
            margin-top: 7px;
            display: block;
            color: #ef4444;
            font-weight: 600;
        }

        .login-form .form-check {
            margin-bottom: 32px;
        }

        .login-form .form-check-input {
            width: 20px;
            height: 20px;
            margin-top: 4px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
        }

        .login-form .form-check-input:checked {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border-color: #3b82f6;
        }

        .login-form .form-check-label {
            margin-bottom: 0;
            font-size: 14px;
            color: #475569;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.45);
            color: white;
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .login-footer {
            text-align: center;
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
        }

        .login-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #1e40af;
        }

        /* ===== REGISTER PAGE - NEW DESIGN ===== */
        .register-container {
            min-height: 100vh;
            display: flex;
            background: #f8fafc;
        }

        .register-info-panel {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 50%, #001f3f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
            position: relative;
            overflow: hidden;
        }

        .register-info-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .register-info-panel::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        .info-content {
            position: relative;
            z-index: 10;
            max-width: 380px;
            color: white;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 60px;
        }

        .info-header i {
            font-size: 50px;
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .info-header h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .info-features {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-bottom: 60px;
        }

        .feature-item {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(59, 130, 246, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 22px;
            color: #60a5fa;
        }

        .feature-text h4 {
            margin: 0 0 6px 0;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        .feature-text p {
            margin: 0;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.4;
        }

        .info-footer {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .register-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
            min-width: 0;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 10px 0;
            font-family: 'Poppins', sans-serif;
        }

        .form-header p {
            color: #64748b;
            font-size: 15px;
            margin: 0;
            font-weight: 500;
        }

        .register-alert {
            padding: 16px 18px;
            border-radius: 12px;
            margin-bottom: 28px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
            font-size: 14px;
        }

        .register-alert i {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .register-alert-danger {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #991b1b;
        }

        .register-alert-danger i {
            color: #ef4444;
        }

        .register-alert strong {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .register-alert ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .register-alert li {
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .register-alert li:last-child {
            margin-bottom: 0;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-group-register {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group-register label {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            color: #94a3b8;
            font-size: 16px;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-wrapper input {
            width: 100%;
            height: 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px 12px 46px;
            font-size: 14px;
            background: white;
            color: #0f172a;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .input-wrapper input::placeholder {
            color: #cbd5e1;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .input-wrapper input:focus + i,
        .input-wrapper input:not(:placeholder-shown) + i {
            color: #3b82f6;
        }

        .input-wrapper input.input-error {
            border-color: #ef4444;
        }

        .input-wrapper input.input-error:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            font-size: 13px;
            color: #ef4444;
            font-weight: 600;
            display: block;
            margin-top: 4px;
        }

        .password-strength {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 6px;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
            background-color: #cbd5e1;
            border-radius: 2px;
        }

        .btn-register-submit {
            height: 52px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Inter', sans-serif;
        }

        .btn-register-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.45);
            color: white;
        }

        .btn-register-submit:active {
            transform: translateY(-1px);
        }

        .btn-register-submit i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .btn-register-submit:hover i {
            transform: translateX(4px);
        }

        .form-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
        }

        .form-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #1e40af;
        }

        /* ===== REGISTER RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .register-info-panel {
                padding: 30px 25px;
            }

            .info-content {
                max-width: 320px;
            }

            .info-header {
                margin-bottom: 45px;
            }

            .info-features {
                margin-bottom: 45px;
                gap: 24px;
            }

            .feature-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .register-info-panel {
                padding: 50px 30px;
                min-height: 40vh;
            }

            .info-content {
                max-width: 100%;
                text-align: center;
            }

            .info-header {
                justify-content: center;
                margin-bottom: 40px;
            }

            .feature-item {
                justify-content: center;
            }

            .register-form-panel {
                padding: 40px 20px;
                min-height: 60vh;
            }

            .form-wrapper {
                max-width: 100%;
            }

            .form-header h2 {
                font-size: 24px;
            }
        }

        .alert {
            border-radius: 14px;
            border: 1px solid var(--border-color);
            margin-bottom: 26px;
            font-size: 14px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 16px 18px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.12) !important;
            border-color: #fca5a5 !important;
            color: #991b1b !important;
        }

        /* Dark mode alerts */
        body.dark-mode .alert {
            background: #1e293b;
            color: #cbd5e1;
            border-color: #475569;
        }

        body.dark-mode .alert-danger {
            background: rgba(220, 38, 38, 0.2) !important;
            border-color: #dc2626 !important;
            color: #fca5a5 !important;
        }

        body.dark-mode .alert-success {
            background: rgba(16, 185, 129, 0.2) !important;
            border-color: #10b981 !important;
            color: #86efac !important;
        }

        body.dark-mode .alert-warning {
            background: rgba(245, 158, 11, 0.2) !important;
            border-color: #f59e0b !important;
            color: #fcd34d !important;
        }

        body.dark-mode .alert-info {
            background: rgba(59, 130, 246, 0.2) !important;
            border-color: #3b82f6 !important;
            color: #93c5fd !important;
        }

        /* Dark mode badges */
        body.dark-mode .badge {
            background: #334155;
            color: #f1f5f9;
        }

        body.dark-mode .badge.bg-primary {
            background: #5b5bff !important;
            color: #ffffff !important;
        }

        body.dark-mode .badge.bg-success {
            background: #10b981 !important;
            color: #ffffff !important;
        }

        body.dark-mode .badge.bg-danger {
            background: #dc2626 !important;
            color: #ffffff !important;
        }

        body.dark-mode .badge.bg-warning {
            background: #f59e0b !important;
            color: #1f2937 !important;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: var(--card-bg) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--text-primary) !important;
            font-size: 22px;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand i {
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-right: 10px;
            font-size: 26px;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
            padding: 8px 16px !important;
            border-radius: 8px;
            margin: 0 4px;
        }

        .nav-link:hover {
            color: #5b5bff !important;
            background: var(--bg-secondary);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            min-height: calc(100vh - 70px);
            padding: 20px 0;
            position: sticky;
            top: 70px;
        }

        .sidebar .menu-header {
            padding: 20px 20px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar .nav {
            padding: 0 10px;
        }

        .sidebar .nav-link {
            color: var(--text-secondary) !important;
            padding: 12px 16px;
            border-radius: 10px;
            margin: 4px 0;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            letter-spacing: 0.3px;
        }

        .sidebar .nav-link i {
            width: 22px;
            margin-right: 12px;
            font-size: 16px;
            text-align: center;
            color: var(--text-tertiary);
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: var(--bg-tertiary);
            color: #5b5bff !important;
            transform: translateX(5px);
        }

        .sidebar .nav-link:hover i {
            color: #5b5bff;
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
            color: white !important;
            box-shadow: var(--shadow-md);
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            background: var(--bg-primary);
            min-height: calc(100vh - 70px);
            padding: 35px 30px;
        }

        /* ===== CARDS ===== */
        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(91, 91, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .icon {
            font-size: 38px;
            margin-bottom: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 14px;
        }

        .stat-card h6 {
            color: var(--text-tertiary);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            font-family: 'Poppins', sans-serif;
        }

        .stat-card.text-primary .number { color: #5b5bff; }
        .stat-card.text-primary .icon { background: rgba(91, 91, 255, 0.1); color: #5b5bff; }

        .stat-card.text-success .number { color: #10b981; }
        .stat-card.text-success .icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }

        .stat-card.text-warning .number { color: #f59e0b; }
        .stat-card.text-warning .icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

        .stat-card.text-info .number { color: #0ea5e9; }
        .stat-card.text-info .icon { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s ease;
            padding: 11px 22px;
            letter-spacing: 0.3px;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(91, 91, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(91, 91, 255, 0.4);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid #5b5bff !important;
            color: #5b5bff !important;
        }

        .btn-outline-primary:hover {
            background: #5b5bff !important;
            color: white !important;
        }

        /* Dark mode buttons */
        body.dark-mode .btn-primary {
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(91, 91, 255, 0.3);
            border: none;
        }

        body.dark-mode .btn-primary:hover {
            background: linear-gradient(135deg, #6b7bff 0%, #1ecb81 100%);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(91, 91, 255, 0.5);
        }

        body.dark-mode .btn-secondary {
            background: #475569;
            color: #f1f5f9;
            border: none;
        }

        body.dark-mode .btn-secondary:hover {
            background: #64748b;
            color: #f1f5f9;
        }

        body.dark-mode .btn-outline-primary {
            border: 2px solid #5b5bff !important;
            color: #5b5bff !important;
        }

        body.dark-mode .btn-outline-primary:hover {
            background: #5b5bff !important;
            color: #ffffff !important;
        }

        body.dark-mode .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        body.dark-mode .btn-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }

        body.dark-mode .btn-success {
            background: #059669;
            color: #ffffff;
        }

        body.dark-mode .btn-success:hover {
            background: #10b981;
            color: #ffffff;
        }

        /* ===== TABLES ===== */
        table {
            font-size: 14px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-responsive {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            background: white;
        }

        body.dark-mode .table-responsive {
            background: #1e293b;
            border-color: #334155;
        }

        .table {
            margin-bottom: 0;
            background: white;
        }

        body.dark-mode .table {
            background: #1e293b;
        }

        thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: none;
            font-weight: 700;
            color: var(--text-primary);
            padding: 18px 16px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        body.dark-mode thead th {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            color: #f1f5f9;
        }

        thead th:first-child {
            border-radius: 16px 0 0 0;
        }

        thead th:last-child {
            border-radius: 0 16px 0 0;
        }

        tbody td {
            border-bottom: 1px solid var(--border-color);
            padding: 16px;
            vertical-align: middle;
            color: var(--text-secondary);
            background: white;
        }

        body.dark-mode tbody td {
            color: #f1f5f9;
            background: #1e293b;
            border-bottom-color: #334155;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:last-child td:first-child {
            border-radius: 0 0 0 16px;
        }

        tbody tr:last-child td:last-child {
            border-radius: 0 0 16px 0;
        }

        tbody tr {
            transition: all 0.3s ease;
            background: white;
        }

        body.dark-mode tbody tr {
            background: #1e293b;
        }

        tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            box-shadow: inset 0 2px 8px rgba(91, 91, 255, 0.05);
        }

        body.dark-mode tbody tr:hover {
            background: linear-gradient(135deg, #334155 0%, #2d3748 100%);
            box-shadow: inset 0 2px 8px rgba(91, 91, 255, 0.15);
        }

        /* ===== UTILITIES ===== */
        .welcome-header {
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .welcome-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-family: 'Poppins', sans-serif;
        }

        .welcome-header p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 15px;
            font-weight: 500;
        }

        .section-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 28px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .section-card .card-header {
            border: none;
            padding: 24px 28px;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-secondary);
        }

        .section-card .card-header h5 {
            margin: 0;
            font-weight: 700;
            color: var(--text-primary);
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
        }

        .section-card .card-body {
            padding: 28px;
        }

        .badge {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .badge.bg-primary { background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%) !important; }
        .badge.bg-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; }
        .badge.bg-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; }
        .badge.bg-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; }
        .badge.bg-info { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important; }

        /* ===== DARK MODE ===== */
        .theme-toggle {
            cursor: pointer;
            padding: 10px 14px;
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.15);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .theme-toggle:hover {
            background-color: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.05);
        }

        body.dark-mode .theme-toggle {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
        }

        body.dark-mode .theme-toggle:hover {
            background-color: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.25);
        }

        /* ===== FORM ELEMENTS ===== */
        .form-control, .form-select {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: var(--card-bg);
            border-color: #5b5bff;
            box-shadow: 0 0 0 4px rgba(91, 91, 255, 0.1);
            color: var(--text-primary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 10px;
            letter-spacing: 0.3px;
        }

        /* Dark mode form elements */
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: #1e293b;
            color: #f1f5f9;
            border-color: #475569;
        }

        body.dark-mode .form-control::placeholder {
            color: #94a3b8;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background: #334155;
            border-color: #5b5bff;
            color: #f1f5f9;
        }

        body.dark-mode .form-label {
            color: #f1f5f9;
        }

        body.dark-mode .form-check-label {
            color: #cbd5e1;
        }

        body.dark-mode .form-text {
            color: #94a3b8;
        }

        body.dark-mode .invalid-feedback {
            color: #fca5a5;
        }

        body.dark-mode select,
        body.dark-mode input[type="text"],
        body.dark-mode input[type="email"],
        body.dark-mode input[type="password"],
        body.dark-mode input[type="number"],
        body.dark-mode input[type="date"],
        body.dark-mode textarea {
            background: #1e293b;
            color: #f1f5f9;
            border-color: #475569;
        }

        body.dark-mode select:focus,
        body.dark-mode input[type="text"]:focus,
        body.dark-mode input[type="email"]:focus,
        body.dark-mode input[type="password"]:focus,
        body.dark-mode input[type="number"]:focus,
        body.dark-mode input[type="date"]:focus,
        body.dark-mode textarea:focus {
            background: #334155;
            border-color: #5b5bff;
            color: #f1f5f9;
        }

        /* Dark mode modals */
        body.dark-mode .modal-content {
            background: #1e293b;
            border: 1px solid #475569;
            color: #f1f5f9;
        }

        body.dark-mode .modal-header {
            border-bottom-color: #475569;
            color: #f1f5f9;
        }

        body.dark-mode .modal-footer {
            border-top-color: #475569;
        }

        body.dark-mode .modal-header .btn-close {
            filter: invert(1) brightness(1.2);
        }

        /* Dark mode dropdowns */
        body.dark-mode .dropdown-menu {
            background: #1e293b;
            border: 1px solid #475569;
        }

        body.dark-mode .dropdown-item {
            color: #cbd5e1;
        }

        body.dark-mode .dropdown-item:hover,
        body.dark-mode .dropdown-item:focus {
            background: #334155;
            color: #f1f5f9;
        }

        body.dark-mode .dropdown-divider {
            border-color: #475569;
        }

        /* Dark mode pagination */
        body.dark-mode .pagination {
            --bs-pagination-bg: #1e293b;
            --bs-pagination-border-color: #475569;
            --bs-pagination-color: #cbd5e1;
        }

        body.dark-mode .page-link {
            background: #1e293b;
            border-color: #475569;
            color: #cbd5e1;
        }

        body.dark-mode .page-link:hover {
            background: #334155;
            border-color: #475569;
            color: #f1f5f9;
        }

        body.dark-mode .page-link.active {
            background: #5b5bff;
            border-color: #5b5bff;
            color: #ffffff;
        }

        /* Dark mode list groups */
        body.dark-mode .list-group {
            --bs-list-group-bg: #1e293b;
            --bs-list-group-border-color: #475569;
            --bs-list-group-color: #cbd5e1;
        }

        body.dark-mode .list-group-item {
            background: #1e293b;
            border-color: #475569;
            color: #cbd5e1;
        }

        body.dark-mode .list-group-item:hover {
            background: #334155;
        }

        body.dark-mode .list-group-item.active {
            background: #5b5bff;
            border-color: #5b5bff;
        }

        /* Dark mode nav tabs */
        body.dark-mode .nav-tabs {
            border-color: #475569;
        }

        body.dark-mode .nav-tabs .nav-link {
            color: #cbd5e1;
        }

        body.dark-mode .nav-tabs .nav-link:hover {
            border-color: #475569;
            color: #f1f5f9;
        }

        body.dark-mode .nav-tabs .nav-link.active {
            background: transparent;
            border-bottom-color: #5b5bff;
            color: #f1f5f9;
        }

        /* Dark mode cards */
        body.dark-mode .card {
            background: #1e293b;
            border-color: #475569;
            color: #cbd5e1;
        }

        body.dark-mode .card-header {
            background: #0f1419;
            border-color: #475569;
        }

        body.dark-mode .card-footer {
            background: #0f1419;
            border-color: #475569;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                padding: 20px 15px;
            }

            .login-card {
                padding: 45px 30px;
            }

            .welcome-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Dark Mode Toggle
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const themeToggle = document.getElementById('themeToggle');
            
            // Load saved theme preference
            const savedTheme = localStorage.getItem('theme') || 'light';
            
            const setTheme = (theme) => {
                if (theme === 'dark') {
                    body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark');
                    if (themeToggle) {
                        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                        themeToggle.title = 'Modo claro';
                    }
                } else {
                    body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light');
                    if (themeToggle) {
                        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                        themeToggle.title = 'Modo oscuro';
                    }
                }
            };
            
            // Apply saved theme on page load
            setTheme(savedTheme);
            
            // Toggle theme on button click
            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
