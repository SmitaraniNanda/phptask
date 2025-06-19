<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if ($token !== 'Bearer simple-static-token') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
