<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = $request->user_id;
        if (!auth()->check() || (!auth()->user()->is_admin && auth()->user()->id != $user_id)) {
            abort(403);
        }

        return $next($request);
    }
}
