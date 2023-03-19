<?php

namespace MetaFramework;


use Illuminate\Support\Facades\{
    App,
    Blade,
    View};
use MetaFramework\Facades\{
    Meta,
    Nav
};
use Illuminate\Pagination\Paginator;
use MetaFramework\Mediaclass\Accessors\Mediaclass;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'metaframework');
        Blade::componentNamespace('\MetaFramework\\Components', 'metaframework');

        $this->loadViewsFrom(__DIR__ . '/Mediaclass/Views', 'mediaclass');
        Blade::componentNamespace('MetaFramework\Mediaclass\\Components', 'mediaclass');

        $this->loadRoutesFrom(__DIR__.'/Mediaclass/Routes/public.php');
        $this->loadRoutesFrom(__DIR__.'/Mediaclass/Routes/panel.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        /**
         * Façades
         */
        App::bind('nav', function () {
            return new Nav();
        });

        App::bind('meta', function () {
            return new Meta();
        });

        App::bind('mediaclass', function () {
            return new Mediaclass();
        });

        View::share('current_locale', App::getLocale());

        Paginator::useBootstrapFive();

        $this->publishConfig();

    }

    private
    function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../publishables/config/' => config_path(),
            __DIR__ . '/../publishables/public/vendor/metaframework' => public_path('vendor/metaframework/'),
            __DIR__ . '/../publishables/lang/' => base_path('lang'),
            __DIR__ . '/../publishables/database/migrations/' => database_path(),
        ], 'metaframework');

    }


}