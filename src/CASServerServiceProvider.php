<?php

namespace Hihuangwei\CAS;

use Illuminate\Support\ServiceProvider;

/**
 * Class CASServerServiceProvider
 * @package Hihuangwei\CAS
 */
class CASServerServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->publishes(
            [
                __DIR__ . '/../config/cas.php' => config_path('cas.php'),
            ],
            'config'
        );

        $this->publishes(
            [
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ],
            'migrations'
        );
    }
}
