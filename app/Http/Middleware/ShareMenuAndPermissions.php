<?php
//modifique este codigo para poder ingresar al aplicativo

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Str;

class ShareMenuAndPermissions
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $userId = $user->id;
            $cacheKey = 'menu_modules_' . $userId;

            $modules = Cache::remember($cacheKey, 60, function () use ($userId) {
                return (new PageController())->getPagesToMenu($userId) ?? [];
            });

            $modules = collect($modules);

            // Obtener el nombre de la ruta actual; si no existe, usar la URI como fallback
            $routeName = Route::currentRouteName();
            if (is_null($routeName) || $routeName === '') {
                // Si la ruta no tiene nombre, usar el path (siempre es string)
                $routeName = $request->path() ?? '';
            }

            // Obtener el "moduleName" (antes usabas Str::before(..., '.'))
            // Aseguramos que $routeName sea string no vacío
            $moduleName = '';
            if (is_string($routeName) && $routeName !== '') {
                // Si la ruta tiene un punto (ej. "enrollment-types.index"), tomamos la parte antes del punto
                $moduleName = Str::contains($routeName, '.') ? Str::before($routeName, '.') : $routeName;
            }

            // Solo llamar al controlador si moduleName es una cadena no vacía
            if (!empty($moduleName)) {
                // Instanciar el RoleController y pedir permisos
                try {
                    $roleController = app(RoleController::class);
                    $permissions = $roleController->getPermissionsPageByRoleId($userId, (string) $moduleName);
                } catch (\Throwable $e) {
                    // En caso de error, no interrumpir la petición; dejar permisos vacíos
                    // Puedes loguear el error si lo deseas:
                    // \Log::error('Error obteniendo permisos: ' . $e->getMessage());
                    $permissions = [];
                }
            } else {
                // Solución temporal: si no hay moduleName, no pedir permisos
                $permissions = [];
            }

            View::share('modules', $modules);
            View::share('permissions', $permissions);
        }

        return $next($request);
    }
}
