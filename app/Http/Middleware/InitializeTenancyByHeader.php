<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyByHeader
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
                'status' => 403,
                'message' => ' Client non spécifié, ID-client manquant',
            ], 403);
        }
        $tenant = Tenant::where('slug' ,$tenantID)->first();

        if(!$tenant){
            //abort(404, 'Client non trouvé');
            return response()->json([
                'status' => 404,
                'message' => "Client non trouvé, ID-client peut être incorrecte",
            ], 404);
        }

        tenancy()->initialize($tenant);

        $tenantId = tenant('id');


        Config::set( "database.connections.tenant",[
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $tenant->database,
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ]);

        DB::purge('tenant');
        DB::connection('tenant');
        // try{
        // }catch(\Exception $error) {
        //     Log::error("Connexion à la base de donnée $tenantId a échouée", ['error' => $error]);
        //     abort(500, "Echec de la connexion à la base $tenantId");

        // }
        return $next($request);
    }
}
