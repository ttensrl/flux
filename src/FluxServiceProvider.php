<?php

namespace TtenSrl\Flux;

use TtenSrl\Flux\Classes\Capacitor;
use TtenSrl\Flux\Http\Components\FluxStatus;
use TtenSrl\Flux\Http\Livewire\FluxStatus as FluxStatusLivewire;
use TtenSrl\Navigator\View\Components\NavigatorMenu as NavigatorMenuComponent;
use TtenSrl\Navigator\View\Components\SystemMenu as SystemMenuComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class FluxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bricks-flux');
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'bricks-flux');
        $this->registerComponent();
        $this->publishingFile();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/bricks-flux.php', 'bricks-flux'
        );
        $this->app->bind('capacitor', function($app) {
            return new Capacitor();
        });
    }

    /**
     * File che possono esssere pubblicati fuori dal Package
     */
    public function publishingFile()
    {
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang/vendor/bricks-flux')], 'Bricks-Flux-Translations');
        $this->publishes([__DIR__.'/../config/bricks-flux.php' => config_path('bricks-flux.php')], 'Bricks-Flux-Config');
        $this->publishes([__DIR__.'/../resources/views/' => resource_path('views/vendor/bricks-flux')], 'Bricks-Flux-View');
    }

    /**
     * Registra i componenti per i Template Blade
     */
    public function registerComponent()
    {
        Blade::component('flux-status', FluxStatus::class);
        Livewire::component('flux-status', FluxStatusLivewire::class);

    }
}
