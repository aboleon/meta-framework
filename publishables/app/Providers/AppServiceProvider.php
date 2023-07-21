<?php


use App\Accessors\Cached;
use MetaFramework\Mediaclass\Accessors\Mediaclass;
use App\Models\Meta;
use App\Models\Nav;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\{
    App,
    Blade,
    Cache,
    View
};
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('path.public', function () {
            return config('app.public_path');
        });
/*
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Password::defaults(function () {
            return Password::min(8);
        });

        Blade::directive('role', function ($arguments) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$arguments})) { ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php } ?>";
        });

        Cache::rememberForever('multilang', fn() => config('translatable.multilang'));


    }
}
