<?php

namespace Aweram\Fileable;

use Illuminate\Support\ServiceProvider;

class FileableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

    }

    public function register(): void
    {
        // Миграции.
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");
    }
}
