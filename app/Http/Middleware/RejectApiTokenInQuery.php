<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RejectApiTokenInQuery
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if($request->query->has('api_token'), 400, 'Use the Authorization header for API authentication.');

        return $next($request);
    }
}
