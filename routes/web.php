<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateUser;
use App\Http\Controllers\Role;
use App\Http\Controllers\Pages;

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

// Rutas para crear usuarios (ejemplo, no implementado en el controlador)
Route::get('/register', [CreateUser::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CreateUser::class, 'register']);

Route::get('/roles', [Role::class, 'getAll'])->name('roles.index');
Route::get('/users', [Role::class, 'getAll'])->name('users.index');
