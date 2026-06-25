<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-IAE-KEY');

        if (!$apiKey) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. X-IAE-KEY header missing or invalid.',
                'errors'  => null,
            ], 401);
        }

        return $next($request);
    }
}
