<?php

declare(strict_types=1);

use App\Http\Controllers\EstimateBookController;
use App\Http\Controllers\TenantController;
use App\Http\Middleware\InitializeTenancyByHeader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByHeader::class,
    //'tenancy'
])->group(function () {
    Route::get('/users', function () {
        if(!tenancy()->initialized){
            return response()->json([
                'status' => 'error',
                'message' => 'Auncun tenant actif',
            ]);
        }
        return response()->json([
            'status' => 'success',
            'database' => tenant(key: 'database'),
            'users' => User::all(),
        ]);
    });

    Route::post('/users', function(Request $request){
        $user = User::create([
            'nom' => $request->nom,
            'pseudo' => $request->pseudo,
            'password' => Hash::make($request->password),
            'role' => $request->role,

            ]);

        return response()->json([
            'message' => 'Création utilisateur réussi',
            'user' => $user,
        ]);
    });

    Route::get('livre-type' , [EstimateBookController::class, 'type']);
    Route::get('livre-dimension' , [EstimateBookController::class, 'dimension']);
    Route::get('livre-papier' , [EstimateBookController::class, 'papier']);
    Route::get('livre-couleur' , [EstimateBookController::class, 'couleur']);
    Route::get('livre-couverture' , [EstimateBookController::class, 'couverture']);
    Route::get('livre-reliure' , [EstimateBookController::class, 'reliure']);
});
