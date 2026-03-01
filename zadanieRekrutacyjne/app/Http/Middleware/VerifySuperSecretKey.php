<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySuperSecretKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $providedKey = $request->header('X-SUPER-SECRET-KEY');
        $expectedKey = env('SUPER_SECRET_KEY');

        if (!$providedKey || $providedKey !== $expectedKey) {
            return response()->json(['message' => 'Unauthorized. Invalid or missing X-SUPER-SECRET-KEY.'], 401);
        }

        return $next($request);
    }
}
