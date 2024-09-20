<?php

namespace App\Providers;

use App\Interfaces\MembreInterface;
use App\Repositories\MembreRepository;
use Illuminate\Support\ServiceProvider;

class MembreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MembreInterface::class, MembreRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
