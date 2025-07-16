<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
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
    'tenant.auth',
    InitializeTenancyByHeader::class,
])->group(function () {

    Route::get('livre' , [EstimateBookController::class, 'livre']);
    Route::post( 'devis-livre', [EstimateBookController::class, 'devisLivre']);
    Route::get( 'devis-livre', [EstimateBookController::class, 'getDevisLivre']);
});
