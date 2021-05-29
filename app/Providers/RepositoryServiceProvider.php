<?php

namespace App\Providers;

use App\Repositories\ListingRepository;
use App\Repositories\ListingRepositoryInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ListingRepositoryInterface::class, ListingRepository::class);
    }
}
