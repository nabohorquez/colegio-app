<?php
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

            // Get current route name; Route::currentRouteName() can return null when
            // a route has not been given a name. Avoid passing null to the controller
            // which expects a string.
            $routeName = Route::currentRouteName();

            if (!$routeName) {
                // No named route: don't attempt to resolve permissions
                $permissions = [];
            } else {
                $moduleName = Str::before($routeName, '.');
                $permissions = (new RoleController())->getPermissionsPageByRoleId($userId, $moduleName);
            }

            View::share('modules', $modules);
            View::share('permissions', $permissions);
        }

        return $next($request);
    }
}
