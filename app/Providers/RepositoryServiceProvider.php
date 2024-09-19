<?php

namespace App\Providers;

use App\Interfaces\GroupeInterface;
use App\Interfaces\UserInterface;
use App\Repositories\GroupeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GroupeInterface::class, GroupeRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
