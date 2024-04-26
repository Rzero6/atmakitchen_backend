<?php

namespace App\Http\Middleware;

use App\Models\Role;
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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roleName = Role::find($request->user()->id_role)->nama;
        if ($request->user() && $roleName === $role) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
