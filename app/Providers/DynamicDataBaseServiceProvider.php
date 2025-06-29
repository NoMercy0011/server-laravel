<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DynamicDataBaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerDynamicConnections();

    }

    protected function registerDynamicConnections() {
$request = request();

            $slug = $request->header('client-id');

            if(!$slug){
                throw new \RuntimeException('ID-Client non spécifié Identification Inconnu');
            }

            $tenant = Tenant::where('slug', $slug)->first();

            if(!$tenant){
                throw new \RuntimeException('Client non trouvé') ;
            }

                Config::set('database.connections.central', [
                    'driver' => 'mysql',
                    'host' => request()->db_host ?? env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT' ,3306),
                    'database' => $tenant->database,
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'=>'',
                    'strict' => true,
                    'engine' => null,
                ]);

                DB::purge('central');
                DB::reconnect('central');
                Config::set('database.default', 'central');
    }
}
