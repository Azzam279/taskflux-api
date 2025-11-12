<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = $request->header('Authorization');
        $expected = 'Bearer ' . config('app.mock_token');

        if ($auth !== $expected) {
            return response()->json([
            'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}
