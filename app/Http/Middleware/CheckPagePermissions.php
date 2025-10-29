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
            return redirect('/login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $routeName = Route::currentRouteName();
        $moduleName = Str::before($routeName, '.') ?? $routeName;
        $permissions = (new RoleController())->getPermissionsPageByRoleId($user->id, $moduleName);

        if (empty($permissions)) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
