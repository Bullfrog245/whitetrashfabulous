<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

class BlockCypherServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SimpleTokenCredential::class, function () {
            return new SimpleTokenCredential(config('services.blockcypher.token'));
        });

        $this->app->singleton(ApiContext::class, function () {
            $credentials = new SimpleTokenCredential(config('services.blockcypher.token'));
            $config = array(
                'mode' => 'sandbox',
                'log.LogEnabled' => true,
                'log.FileName' => '../BlockCypher.log',
                'log.LogLevel' => 'DEBUG', // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'validation.level' => 'log',
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            );
        
            return ApiContext::create($credentials, $config);
        });
    }
}
