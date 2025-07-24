<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Cache::get('maintenance_mode', false) && !Auth::check()) {
            return response()->view('errors.maintenance');
        }

        return $next($request);
    }
}
