<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PageMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lewatkan jika admin
        if (Auth::user()?->is_admin) {
            return $next($request);
        }

        // 1. Coba ambil dari nama route (lebih akurat dan prioritas utama)
        $routeName = $request->route()?->getName();
        $prefixes = ['auth.', 'guest.', 'admin.'];
        $page = null;

        foreach ($prefixes as $prefix) {
            if (Str::startsWith($routeName, $prefix)) {
                $page = Str::after($routeName, $prefix); // e.g. "dashboard"
                break;
            }
        }

        // 2. Jika tidak dapat dari route name (seperti pada [id]/edit), fallback ke segment[1]
        if (!$page) {
            $segments = $request->segments(); // e.g. ['auth', 'emergency', '1', 'edit']
            $page = $segments[1] ?? null;     // -> 'emergency'
        }

        $pages = Cache::get('maintenance_pages', []);

        if ($page && ($pages[$page] ?? false)) {
            return response()->view('errors.maintenance');
        }
        return $next($request);
    }
}
