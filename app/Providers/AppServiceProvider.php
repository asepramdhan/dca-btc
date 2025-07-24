<?php

namespace App\Providers;

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // arahkan ke lokasi build di hosting
        // Vite::useBuildDirectory('../../public_html/build');

        Vite::useBuildDirectory('build');

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // register middleware
        Route::aliasMiddleware('is_admin', IsAdmin::class);
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->is_admin;
        });
    }
}
