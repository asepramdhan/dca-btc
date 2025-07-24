<?php

namespace App\Providers;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\PageMaintenance;
use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Folio::path(resource_path('views/pages'))->middleware([
            'guest/*' => [
                'guest',
            ],
            'auth/*' => [
                'auth',
            ],
            'admin/*' => [
                'auth',
                IsAdmin::class, // <- pakai class, bukan string
            ],
            '*' => [
                PageMaintenance::class, // ← Semua route dicek, tapi hanya blok yang diset
            ],
        ]);
    }
}
