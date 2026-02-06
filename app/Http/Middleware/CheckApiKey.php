<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('x-api-key');
        if ($key !== config('app.api_key')) {
            return FacadesResponse::json([
                'message' => 'Invalid API Key'
            ], 422);
        }

        // now i need to update the ip address for the user device
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $user->currentAccessToken()->forceFill([
                'ip_address' => $request->ip()
            ])->save();
        }

        return $next($request);
    }
}
