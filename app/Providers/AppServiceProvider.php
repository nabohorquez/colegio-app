<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PageController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $userId = auth()->id();
            $cacheKey = 'menu_modules_' . ($userId ?? 'guest');

            $modules = Cache::remember($cacheKey, 60, function () use ($userId) {
                $pagesController = new PageController();
                $result = $pagesController->getPagesToMenu($userId);
                return $result ?? [];
            });

            if (!($modules instanceof \Illuminate\Support\Collection)) {
                $modules = collect($modules ?? []);
            }

            $view->with('modules', $modules);
        });
    }
}
