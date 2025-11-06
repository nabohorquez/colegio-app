<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateUser;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EnrollmentTypeController;

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para crear usuarios (ejemplo, no implementado en el controlador)
Route::get('/register', [CreateUser::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CreateUser::class, 'register']);

// Rutas protegidas por autenticación
Route::middleware(['auth', 'check.page.permissions'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Roles y usuarios
    Route::get('/roles', [RoleController::class, 'getAll'])->name('roles.index');
    Route::get('/users', [RoleController::class, 'getAll'])->name('users.index');

    // Módulos
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [ModuleController::class, 'getAll'])->name('index');
        Route::get('/create', [ModuleController::class, 'viewCreate'])->name('viewCreate');
        Route::post('/', [ModuleController::class, 'create'])->name('create');
        Route::get('/{id}', [ModuleController::class, 'getById'])->name('getById');
        Route::put('/{id}', [ModuleController::class, 'update'])->name('update');
        Route::delete('/{id}', [ModuleController::class, 'delete'])->name('delete');
    });

    // Páginas
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PageController::class, 'getAll'])->name('index');
        Route::get('/create', [PageController::class, 'viewCreate'])->name('viewCreate');
        Route::post('/', [PageController::class, 'create'])->name('create');
        Route::get('/{id}', [PageController::class, 'getById'])->name('getById');
        Route::put('/{id}', [PageController::class, 'update'])->name('update');
        Route::delete('/{id}', [PageController::class, 'delete'])->name('delete');
    });

    Route::prefix('enrollment-types')->name('enrollment-types.')->group(function () {
        Route::get('/', [EnrollmentTypeController::class, 'getAll'])->name('index');
        Route::get('/create', [EnrollmentTypeController::class, 'viewCreate'])->name('create');
        Route::post('/', [EnrollmentTypeController::class, 'create'])->name('store');
        Route::get('/{id}', [EnrollmentTypeController::class, 'getById'])->name('edit');
        Route::put('/{id}', [EnrollmentTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [EnrollmentTypeController::class, 'delete'])->name('destroy');
        Route::get('/{id}/show', [EnrollmentTypeController::class, 'show'])->name('show');
    });




});
