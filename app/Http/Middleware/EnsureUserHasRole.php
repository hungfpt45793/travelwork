<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Restrict a route to one or more numeric application roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array((string) $user->role, $roles, true)) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}
