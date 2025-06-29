<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events\TenancyInitialized;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->app['events']->listen(TenancyInitialized::class, function (TenancyInitialized $event) {
        //     // Configurer la connexion tenant avec la bonne base de données
        //     config([
        //         'database.connections.tenant.database' => $event->tenancy->tenant->database
        //     ]);

        //     // Purger la connexion pour forcer une nouvelle connexion
        //     \Illuminate\Support\Facades\DB::purge('tenant');
        // });
    }
}
