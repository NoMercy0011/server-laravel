<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\InitializeTenancyByHeader;
use App\Http\Middleware\VerifyDataBaseAccess;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('login', [AuthController::class, 'authenticate']);
// Route::post('register', [AuthController::class, 'register']);

// Route::get('hello', [AuthController::class, 'hello']);
// Route::get('data', [AuthController::class, 'getData']);
// Route::get('dashboard', [AuthController::class, 'dashboard'])
//     ->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function (){
//     Route::get('user', [AuthController::class, 'user']);
//     Route::get('secret', [AuthController::class, 'secret']);
//     Route::get('/test', [AuthController::class , 'getUser']);
// });

// Route::middleware([
//     'api',
//     InitializeTenancyByRequestData::class,
//     //PreventAccessFromCentralDomains::class,
// ])->group(function () {
//     Route::get('/users', function () {
//         return \App\Models\User::all();
//     });
// });


Route::middleware([
    'api',
])->group(function () {
    Route::post('/tenants', function (Request $request) {
        $tenant = Tenant::create([
            'nom' => $request->nom,
            'slug'=> $request->slug,
            'database'=> $request->database,
        ]);

        //$tenant->domains()->create([ 'domain' => $request->domain]);

        return response()->json([
            'message' => 'Success'
            ], 201);
    });

    Route::get('/tenants', function () {
        return Tenant::all();
    });
});
