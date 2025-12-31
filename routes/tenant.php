<?php

declare(strict_types=1);

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EstimateBookController;
use App\Http\Middleware\InitializeTenancyByHeader;
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
    
    Route::delete( 'client', [ClientController::class, 'delete']);

    Route::put( 'client', [ClientController::class, 'update']);


    Route::post( 'devis-livre', [EstimateBookController::class, 'devisLivre']);
    Route::post('commande', [CommandeController::class, 'create']);
    Route::post('document-facture', [DocumentController::class, 'createFacture']);
    Route::post('document-proforma', [DocumentController::class, 'createProforma']);
    Route::post( 'client', [ClientController::class, 'create']);
    Route::post( 'commercial', [CommercialController::class, 'create']);

    Route::get( 'client-id', [ClientController::class, 'getClientID']);
    Route::get( 'client', [ClientController::class, 'get']);
    Route::get( 'commercial', [CommercialController::class, 'get']);
    Route::get('livre' , [EstimateBookController::class, 'livre']);
    Route::get( 'devis-livre', [EstimateBookController::class, 'getDevisLivre']);
    Route::get('commande', [CommandeController::class, 'get']);
    Route::get('document', [DocumentController::class, 'getDocument']);

    Route::get('packaging', [CatalogueController::class, 'getPackaging']);
    Route::get('calendar', [CatalogueController::class, 'getCalendar']);
    Route::get('chevalet', [CatalogueController::class, 'getChevalet']);
    Route::get('carterie', [CatalogueController::class, 'getCarterie']);
    Route::get('flyers', [CatalogueController::class, 'getFlyers']);

});
