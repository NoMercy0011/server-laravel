<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PSpell\Config;

class TenantController extends Controller
{
    public function connection(){

        if(tenancy()->initialized) {
            $users = Tenant::all(); //DB::connection('tenant')->table('users')->get();
        }

        return response()->json([
            'status' => 'success',
            'tenant_db' => config('database.connections.tenant.database'),
            'actuelle_connexion' =>DB::connection('tenant')->getDatabaseName(),
            'user' => $users,
        ]);
    }
}
