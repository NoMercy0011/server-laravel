<?php

namespace App\Http\Middleware;

use App\Models\Models\TenantAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VerifyTenantToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $header = $request->header('Authorization');

        if(!$header || ! str_starts_with($header ,'Bearer')){
            return response()->json([
                'status' => 401,
                'message' => 'Token manquant.',
                'Database' => DB::connection('tenant')->getDatabaseName(),
            ], 401);
        }

        $token = str_replace('Bearer', '', $header);
        $accessToken = TenantAccessToken::findToken($token);

        if(! $accessToken){
            return response()->json([
                'status' => 401,
                'message' => 'Token invalide.',
                'Database' => DB::connection('tenant')->getDatabaseName(),
            ],401);
        }

        $request->setUserResolver(function() use($accessToken) {
            return $accessToken->tokenable;
        });
        return $next($request);
    }
}
