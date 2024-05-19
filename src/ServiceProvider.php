<?php

namespace Aboleon\MetaFramework;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\{
    App,
    Blade,
    View};
use Aboleon\MetaFramework\Facades\MetaFacade;
use Aboleon\MetaFramework\Facades\NavFacade;
use Aboleon\MetaFramework\Mediaclass\Facades\MediaclassFacade;
use Aboleon\MetaFramework\Mediaclass\Mediaclass;
use Aboleon\MetaFramework\Models\Meta;
use Aboleon\MetaFramework\Models\Nav;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        /**
         * Façades
         */
        $this->app->singleton('nav', fn($app) => new Nav());
        $this->app->singleton('meta', fn($app) => new Meta());
        $this->app->singleton('mediaclass', fn($app) => new Mediaclass());

        $this->app->bind(NavFacade::class, fn($app) => new NavFacade());
        $this->app->bind(MetaFacade::class, fn($app) => new MetaFacade());
        $this->app->bind(MediaclassFacade::class, fn($app) => new MediaclassFacade());

    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'aboleon-framework');
        Blade::componentNamespace('Aboleon\MetaFramework\\Components', 'aboleon-framework');

        $this->loadViewsFrom(__DIR__ . '/Mediaclass/Views', 'mediaclass');
        Blade::componentNamespace('Aboleon\MetaFramework\\Mediaclass\\Components', 'mediaclass');

        $this->loadRoutesFrom(__DIR__.'/Mediaclass/Routes/public.php');
        $this->loadRoutesFrom(__DIR__.'/Mediaclass/Routes/panel.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');


        View::share('current_locale', App::getLocale());

        Paginator::useBootstrapFive();

        $this->publishInstall();
        $this->publishAssets();
        $this->publishLang();
        $this->publishMediaclass();

    }

    private function publishInstall(): void
    {
        $this->publishes([
            __DIR__ . '/../publishables/config/' => config_path(),
            __DIR__ . '/../publishables/public/' => public_path(),
            __DIR__ . '/../publishables/lang/' => base_path('lang'),
            __DIR__ . '/../publishables/database/' => database_path(),
            __DIR__ . '/../publishables/app/' => app_path(),
            __DIR__ . '/../publishables/resources/' => resource_path(),
            __DIR__ . '/../publishables/routes/' => base_path('routes'),
        ], 'aboleon-framework-install');

    }

    private function publishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../publishables/public/vendor/' => public_path('vendor/'),
        ], 'aboleon-framework-assets');

    }

    private function publishLang(): void
    {
        $this->publishes([
            __DIR__ . '/../publishables/lang/' => base_path('lang'),
        ], 'aboleon-framework-lang');

    }

    private function publishMediaclass(): void
    {
        $this->publishes([
            __DIR__ . '/../publishables/public/vendor/aboleon/mediaclass/' => public_path('vendor/aboleon/mediaclass/'),
            __DIR__ . '/../publishables/lang/fr/mediaclass.php' => base_path('lang/fr/mediaclass.php'),
            __DIR__ . '/../publishables/lang/en/mediaclass.php' => base_path('lang/en/mediaclass.php'),
        ], 'aboleon-framework-mediaclass');

    }
}