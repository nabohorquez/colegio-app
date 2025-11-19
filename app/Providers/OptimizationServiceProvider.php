<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class OptimizationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mostrar consultas lentas en desarrollo
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
    }
}

