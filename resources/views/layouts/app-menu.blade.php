@extends('layouts.app')

@section('title', 'Sistema Escolar')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg" aria-label="Main navigation">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-school"></i>Mi Colegio
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <button class="nav-link theme-toggle" id="themeToggle" title="Cambiar tema">
                        <i class="fas fa-moon"></i>
                    </button>
                </li>
                <li class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-circle me-2"></i>Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Configuración
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0 d-none d-md-block">
            <div class="sidebar">
                <div class="menu-header">
                    <i class="fas fa-bars me-2"></i>Menú
                </div>
                <nav class="nav flex-column" aria-label="dashboard">
                    @php
                        $currentRoute = Route::currentRouteName();
                        $currentBase = $currentRoute ? Str::before($currentRoute, '.') : '';
                    @endphp
                    @if(empty($modules))
                        <a class="nav-link {{ $currentBase == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        @foreach($modules as $module)
                            @php
                                $moduleRoute = $module->route ?? '';
                            @endphp
                            @if(empty($module->sub_pages))
                                <a
                                    class="nav-link {{ ($moduleRoute && Route::has($moduleRoute) && $currentBase == Str::before($moduleRoute, '.')) ? 'active' : '' }} {{ (!$moduleRoute || !Route::has($moduleRoute)) ? 'disabled' : '' }}"
                                    href="{{ ($moduleRoute && Route::has($moduleRoute)) ? route($moduleRoute) : '#' }}"
                                >
                                    <i class="fas fa-book"></i>
                                    <span>{{ $module->page_name }}</span>
                                </a>
                            @else
                                <a class="nav-link" href="#module-{{ $module->id }}" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fas fa-folder"></i>
                                    <span>{{ $module->page_name }}</span>
                                </a>
                                <div class="collapse" id="module-{{ $module->id }}">
                                    @foreach($module->sub_pages as $sub_page)
                                        @php $subRoute = $sub_page->route ?? ''; @endphp
                                        @if(empty($sub_page->components))
                                            <a 
                                                class="nav-link {{ ($subRoute && Route::has($subRoute) && $currentBase == Str::before($subRoute, '.')) ? 'active' : '' }} {{ (!$subRoute || !Route::has($subRoute)) ? 'disabled' : '' }}" 
                                                href="{{ ($subRoute && Route::has($subRoute)) ? route($subRoute) : '#' }}"
                                            >
                                                <i class="fas fa-file"></i>
                                                <span>{{ $sub_page->page_name }}</span>
                                            </a>
                                        @else
                                            <a class="nav-link" href="#subpage-{{ $sub_page->id }}" data-bs-toggle="collapse" aria-expanded="false">
                                                <i class="fas fa-file"></i>
                                                <span>{{ $sub_page->page_name }}</span>
                                            </a>
                                            <div class="collapse" id="subpage-{{ $sub_page->id }}">
                                                @foreach($sub_page->components as $component)
                                                    @php $compRoute = $component->route ?? ''; @endphp
                                                    <a
                                                        class="nav-link {{ ($compRoute && Route::has($compRoute) && $currentBase == Str::before($compRoute, '.')) ? 'active' : '' }} {{ (!$compRoute || !Route::has($compRoute)) ? 'disabled' : '' }}"
                                                        href="{{ ($compRoute && Route::has($compRoute)) ? route($compRoute) : '#' }}"
                                                    >
                                                        <i class="fas fa-cube"></i>
                                                        <span>{{ $component->page_name }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            @yield('content-principal')
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection
