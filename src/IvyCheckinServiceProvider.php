<?php

namespace RootXS;

use Illuminate\Support\ServiceProvider;

/**
 * Ivy Module: Checkin
 *
 * Service Provider
 */
class IvyCheckinServiceProvider extends ServiceProvider
{

    /** @var bool $defer Indicates if loading of the provider is deferred. */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(IvyCheckin::class, function ($app) {
            return new IvyCheckin(config('ivy.modules.checkin'));
        });
    }

    /**
     * Bootstrap the configuration.
     */
    public function boot()
    {
        // Routing
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }

        // Views & Translations
        $this->loadViewsFrom(__DIR__ . '/../views', 'ivy-checkin'); // usage: view('ivy-checkin::index')
        // $this->loadTranslationsFrom(__DIR__ . '/path/to/translations', 'courier'); // usage: trans('ivy-checkin::messages.welcome')

        // Publish all the things!
        $this->publishes([
            __DIR__ . '/../config/checkin.php' => config_path('ivy/modules/checkin.php'), // config
            __DIR__ . '/../views' => resource_path('views/vendor/ivy-checkin'), // views
            // __DIR__ . '/../lang' => resource_path('lang/ivy/checkin'), // translations
            __DIR__ . '/../public' => public_path('ivy/checkin'), // public assets
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../config/checkin.php', 'ivy.modules.checkin');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [IvyCheckin::class];
    }

}
