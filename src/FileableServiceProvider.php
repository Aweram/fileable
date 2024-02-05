<?php

namespace Aweram\Fileable;

use Aweram\Fileable\Livewire\ImageIndexWire;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class FileableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Подключение views.
        $this->loadViewsFrom(__DIR__ . "/resources/views", "fa");

        // Livewire
        $component = config("fileable.customImageIndexComponent");
        Livewire::component(
            "fa-images",
            $component ?? ImageIndexWire::class
        );
    }

    public function register(): void
    {
        // Миграции.
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");

        // Подключение конфигурации.
        $this->mergeConfigFrom(
            __DIR__ . "/config/fileable.php", "fileable"
        );
    }
}
