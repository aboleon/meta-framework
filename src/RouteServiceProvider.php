<?php

namespace Aboleon\MetaFramework;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Aboleon\MetaFramework\Accessors\Routing;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $defer = false;
    protected $namespace = '\Aboleon\MetaFramework\Controllers';
    public const HOME = '/';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::prefix(Routing::backend())
            ->middleware(['web', 'auth:sanctum'])
            ->namespace($this->namespace)
            ->name('aboleon-framework.')
            ->group(function () {
                include __DIR__ . '/Routes/web.php';
            });

        Route::prefix('mediaclass')
            ->name('mediaclass.')
            ->group(function () {
                include __DIR__ . '/Mediaclass/Routes/public.php';
                include __DIR__ . '/Mediaclass/Routes/panel.php';
            });
    }
}
