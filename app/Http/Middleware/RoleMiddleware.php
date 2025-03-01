<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (!auth()->check() || !auth()->user()->hasAnyRole($role) && request()->routeIs('inspector.store') === false) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
