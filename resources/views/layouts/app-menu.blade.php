@extends('layouts.app')

@section('title', 'AcademicSoftware')

@section('content')
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-file-invoice-dollar me-2"></i>AcademicSoftware
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-cog me-1"></i>Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-1"></i>Configuración
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
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
            <div class="col-md-3 col-lg-2 p-0">
                <div class="sidebar h-100">
                    <div class="p-3">
                        <h6 class="text-white-50 text-uppercase">Menú Principal</h6>
                    </div>
                    <nav class="nav flex-column px-3" aria-label="dashboard">
                        @foreach($modules as $module)
                            @if(empty($module->sub_pages))
                                <a
                                    class="nav-link {{ Route::currentRouteName() == $module->route ? 'active' : '' }}"
                                    href="{{ route($module->route) }}"
                                >
                                    <i class="fas fa-file-alt me-2"></i>{{ $module->page_name }}
                                </a>
                            @else
                                <a class="nav-link" href="#module-{{ $module->id }}" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fas fa-folder me-2"></i>{{ $module->page_name }}
                                </a>
                                <div class="collapse ps-3" id="module-{{ $module->id }}">
                                    @foreach($module->sub_pages as $sub_page)
                                        @if(empty($sub_page->components))
                                            <a class="nav-link {{ Route::currentRouteName() == $sub_page->route ? 'active' : '' }}" href="{{ route($sub_page->route) }}">
                                                <i class="fas fa-file-alt me-2"></i>{{ $sub_page->page_name }}
                                            </a>
                                        @else
                                            <a class="nav-link" href="#subpage-{{ $sub_page->id }}" data-bs-toggle="collapse" aria-expanded="false">
                                                <i class="fas fa-file-alt me-2"></i>{{ $sub_page->page_name }}
                                            </a>
                                            <div class="collapse ps-3" id="subpage-{{ $sub_page->id }}">
                                                @foreach($sub_page->components as $component)
                                                    <a
                                                        class="nav-link {{ Route::currentRouteName() == $component->route ? 'active' : '' }}"
                                                        href="{{ route($component->route) }}"
                                                    >
                                                        <i class="fas fa-cube me-2"></i>{{ $component->page_name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4 main-content">
                @yield('content-principal')
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@endsection
