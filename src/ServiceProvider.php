<?php

namespace MetaFramework;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'metaframework');
        Blade::componentNamespace('\MetaFramework\\Components', 'metaframework');

        View::share('current_locale', App::getLocale());

        $this->publishConfig();

    }

    private function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../publishables/config/metaframework.php' => config_path('metaframework.php'),
            __DIR__ . '/../publishables/assets/' => public_path('vendor/metaframework/'),
            __DIR__ . '/../publishables/lang/' => base_path('lang'),
        ], 'metaframework');
    }


}