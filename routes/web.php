<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateUser;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\GradeController;

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect('/login');
})->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para crear usuarios (ejemplo, no implementado en el controlador)
Route::get('/register', [CreateUser::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CreateUser::class, 'register'])->name('register.post');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'check.page.permissions'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/roles', [RoleController::class, 'getAll'])->name('roles.index');
    Route::get('/users', [RoleController::class, 'getAll'])->name('users.index');

    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [ModuleController::class, 'getAll'])->name('index');
        Route::get('/create', [ModuleController::class, 'viewCreate'])->name('viewCreate');
        Route::post('/', [ModuleController::class, 'create'])->name('create');
        Route::get('/{id}', [ModuleController::class, 'getById'])->name('getById');
        Route::put('/{id}', [ModuleController::class, 'update'])->name('update');
        Route::delete('/{id}', [ModuleController::class, 'delete'])->name('delete');
    });

    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PageController::class, 'getAll'])->name('index');
        Route::get('/create', [PageController::class, 'viewCreate'])->name('viewCreate');
        Route::post('/', [PageController::class, 'create'])->name('create');
        Route::get('/{id}', [PageController::class, 'getById'])->name('getById');
        Route::put('/{id}', [PageController::class, 'update'])->name('update');
        Route::delete('/{id}', [PageController::class, 'delete'])->name('delete');
    });

    Route::middleware(['auth', 'check.page.permissions'])->prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'getAll'])->name('index');
        Route::get('/create', [EmployeeController::class, 'viewCreate'])->name('viewCreate');
        Route::post('/', [EmployeeController::class, 'create'])->name('create');
        Route::get('/{id}', [EmployeeController::class, 'getById'])->name('getById');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{id}', [EmployeeController::class, 'delete'])->name('delete');
    });

    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'getAll'])->name('index');
        Route::get('/create', [EmployeeController::class, 'viewCreate'])->name('viewCreate');
        Route::post('/', [EmployeeController::class, 'create'])->name('create');
        Route::get('/{id}', [EmployeeController::class, 'getById'])->name('getById'); // ✅ para modal
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update'); // ✅ AJAX update
        Route::delete('/{id}', [EmployeeController::class, 'delete'])->name('delete');
        Route::delete('/employees/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');

    });


    Route::middleware(['auth', 'check.page.permissions'])->group(function () {
        Route::prefix('guardians')->name('guardians.')->group(function () {
            Route::get('/', [GuardianController::class, 'getAll'])->name('index');
            Route::get('/{id}', [GuardianController::class, 'getById'])->name('getById');
            Route::post('/', [GuardianController::class, 'create'])->name('create');
            Route::put('/{id}', [GuardianController::class, 'update'])->name('update');
            Route::delete('/{id}', [GuardianController::class, 'delete'])->name('delete');
            Route::get('/guardians/create', [GuardianController::class, 'viewCreate'])->name('guardians.viewCreate');

        });

        Route::prefix('students')->name('students.')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::post('/', [StudentController::class, 'store'])->name('store');
            Route::get('/{id}', [StudentController::class, 'getById'])->name('show');
            Route::put('/{id}', [StudentController::class, 'update'])->name('update');
            Route::delete('/{id}', [StudentController::class, 'destroy'])->name('destroy');
        });
    });



    // Rutas de administración de colegio
    Route::prefix('school')->name('school.')->group(function () {
        Route::get('/admin', function() {
            return view('school_admin.index');
        })->name('admin');

        // Rutas de topics dentro de administración del colegio
        Route::prefix('admin/topics')->name('topics.')->group(function () {
            Route::get('/', [TopicsController::class, 'index'])->name('index');
            Route::get('/create', [TopicsController::class, 'create'])->name('create');
            Route::post('/', [TopicsController::class, 'store'])->name('store');
            Route::get('/{topic}', [TopicsController::class, 'show'])->name('show');
            Route::get('/{topic}/edit', [TopicsController::class, 'edit'])->name('edit');
            Route::put('/{topic}', [TopicsController::class, 'update'])->name('update');
            Route::delete('/{topic}', [TopicsController::class, 'destroy'])->name('destroy');
        });

        // Rutas de activities dentro de administración del colegio
        Route::prefix('admin/activities')->name('activities.')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/create', [ActivityController::class, 'create'])->name('create');
            Route::post('/', [ActivityController::class, 'store'])->name('store');
            Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
            Route::get('/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
            Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
            Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
        });

            // Rutas de grades dentro de administración del colegio
            Route::prefix('admin/grades')->name('grades.')->group(function () {
                Route::get('/', [GradeController::class, 'index'])->name('index');
                Route::get('/create', [GradeController::class, 'create'])->name('create');
                Route::post('/', [GradeController::class, 'store'])->name('store');
                Route::get('/student/{student}', [GradeController::class, 'studentGrades'])->name('student');
                Route::get('/{grade}', [GradeController::class, 'show'])->name('show');
                Route::get('/{grade}/edit', [GradeController::class, 'edit'])->name('edit');
                Route::put('/{grade}', [GradeController::class, 'update'])->name('update');
                Route::delete('/{grade}', [GradeController::class, 'destroy'])->name('destroy');
            });
        });


    
});
