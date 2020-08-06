<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bind the interface for implementation of repository class
     */
    public function register()
    {
        $this->app->bind("App\Repositories\Client\ClientRepository", "App\Repositories\Client\ClientRepositoryService");
    }
}
