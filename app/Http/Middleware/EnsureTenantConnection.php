<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantID = $request->header('client-id');

        if(!$tenantID){
            return response()->json([
                'message' => ' Client non spécifié, ID-client manquant',
            ], 403);
        }
        $tenant = Tenant::where('slug' ,$tenantID)->firstOrFail();

        if(!$tenant){
            return response()->json([
                'message' => "Tenant n'exite pas",
            ], 404);
        }

        tenancy()->initialize($tenant);
        $tenantId = tenant('id');

        DB::purge('tenant');

        config([
            'database.connections.tenant.database' => 'client_'.$tenantId,
            'database.connections.username' => env('DB_USERNAME'),
            'database.connections.password' => env('DB_PASSWORD'),
        ]);

        try{
            DB::connection('tenant.database')->getPdo();
        }catch(\Exception $error) {
            Log::error("Connexion à la base de donnée $tenantId a échouée", ['error' => $error]);
            abort(500, "Echec de la connexion à la base $tenantId");

        }
        return $next($request);
    }
}
