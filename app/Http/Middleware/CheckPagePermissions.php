<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Str;

class CheckPagePermissions
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No autenticado'], 401);
            }
            return redirect('/login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $routeName = Route::currentRouteName();

        // Si no hay nombre de ruta, no intentamos resolver permisos (evita pasar null a Str::before)
        if (!$routeName) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sin permisos'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $moduleName = Str::before($routeName, '.') ?: $routeName;
        $permissions = (new RoleController())->getPermissionsPageByRoleId($user->id, $moduleName);

        if (empty($permissions)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sin permisos para este módulo'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
