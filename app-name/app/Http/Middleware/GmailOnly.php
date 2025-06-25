<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GmailOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !str_ends_with($user->email, '@gmail.com')) {
            return response()->json(['error' => 'Access denied. Only Gmail users allowed.'], 403);
        }

        return $next($request);
    }
}
