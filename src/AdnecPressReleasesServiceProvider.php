<?php

namespace Aaw0\AdnecPressReleases;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class AdnecPressReleasesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::resources([
            AdnecPressRelease::class
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function register()
    {

    }
}
