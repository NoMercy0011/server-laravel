<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageUpdatedController;
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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'authenticate']);


Route::middleware('tenant.auth' )->group(function (){
    Route::get('user', function(Request $request){
        return response()->json($request->user());
    });
});

Route::post('/send-message', [MessageUpdatedController::class, 'send']);
Route::get('/' , function(){
    return response()->json([
        "message" => 'HELLO CLIENT',
    ]);
});