<?php

namespace MetaFramework;


use Illuminate\Support\Facades\{
    App,
    Blade,
    View};
use Illuminate\Pagination\Paginator;
use MetaFramework\Facades\MetaFacade;
use MetaFramework\Facades\NavFacade;
use MetaFramework\Mediaclass\Accessors\Mediaclass;
use MetaFramework\Mediaclass\Facades\MediaclassFacade;
use MetaFramework\Models\Meta;
use MetaFramework\Models\Nav;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        /**
         * Façades
         */
        $this->app->singleton('nav', fn($app) => new Nav());
        $this->app->singleton('meta', fn($app) => new Meta());
        $this->app->singleton('mediaclass', fn($app) => new Mediaclass());
        $this->app->singleton('mediaclass', fn($app) => new Mediaclass());


        $this->app->bind('MetaFramework\Facades\NavFacade', fn($app) => new NavFacade());
        $this->app->bind('MetaFramework\Facades\MetaFacade', fn($app) => new MetaFacade());
        $this->app->bind('MetaFramework\Mediaclass\Facades\MediaclassFacade', fn($app) => new MediaclassFacade());
        $this->app->bind('MetaFramework\Mediaclass\Facades\MediaclassFacade', fn($app) => new MediaclassFacade());

    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'mfw');
        Blade::componentNamespace('\MetaFramework\\Components', 'mfw');

        $this->loadViewsFrom(__DIR__ . '/Mediaclass/Views', 'mediaclass');
        Blade::componentNamespace('MetaFramework\Mediaclass\\Components', 'mediaclass');

        $this->loadRoutesFrom(__DIR__.'/Mediaclass/Routes/public.php');
        $this->loadRoutesFrom(__DIR__.'/Mediaclass/Routes/panel.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');


        View::share('current_locale', App::getLocale());

        Paginator::useBootstrapFive();

        $this->publishConfig();

    }

    private
    function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../publishables/config/' => config_path(),
            __DIR__ . '/../publishables/public/vendor/mfw' => public_path('vendor/mfw/'),
            __DIR__ . '/../publishables/lang/' => base_path('lang'),
            __DIR__ . '/../publishables/database/migrations/' => database_path(),
        ], 'mfw');

    }


}