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
            background: linear-gradient(135deg, #5b5bff 0%, #3b3bdd 50%, #10b981 100%);
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
            background: rgba(255, 255, 255, 0.05);
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
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 60px 45px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .school-logo {
            font-size: 60px;
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
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
            font-weight: 700;
            color: #1a202c;
            margin: 0 0 12px 0;
            font-family: 'Poppins', sans-serif;
        }

        .login-header .subtitle {
            color: #718096;
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
            font-weight: 600;
            color: #1a202c;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .login-form .form-control {
            height: 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .login-form .form-control:focus {
            border-color: #5b5bff;
            box-shadow: 0 0 0 4px rgba(91, 91, 255, 0.1);
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
            font-weight: 500;
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
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
            border-color: #5b5bff;
        }

        .login-form .form-check-label {
            margin-bottom: 0;
            font-size: 14px;
            color: #4a5568;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #5b5bff 0%, #10b981 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(91, 91, 255, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(91, 91, 255, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .login-footer {
            text-align: center;
            font-size: 14px;
            color: #718096;
            font-weight: 500;
        }

        .login-footer a {
            color: #5b5bff;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #10b981;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 26px;
            font-size: 13px;
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1) !important;
            border-color: #fca5a5 !important;
            color: #b91c1c !important;
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

        /* ===== TABLES ===== */
        table {
            font-size: 14px;
        }

        thead th {
            background: var(--bg-secondary);
            border-top: none;
            border-bottom: 2px solid var(--border-color);
            font-weight: 700;
            color: var(--text-primary);
            padding: 16px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        tbody td {
            border-bottom: 1px solid var(--border-color);
            padding: 16px;
            vertical-align: middle;
            color: var(--text-secondary);
        }

        tbody tr:hover {
            background: var(--bg-secondary);
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
