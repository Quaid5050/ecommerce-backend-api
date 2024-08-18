<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Passport\Client;
class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientId = $request->header('client-id'); // Get the client ID from the request header

        // Check if the client ID exists in the Passport clients table
        $client = Client::find($clientId);


        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not allowed',
            ], 403);
        }

        return $next($request);
    }
}
