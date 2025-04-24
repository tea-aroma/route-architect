<?php

namespace TeaAroma\RouteArchitect\Providers;


use Illuminate\Support\ServiceProvider;
use TeaAroma\RouteArchitect\Console\Commands\MakeRouteArchitect;


/**
 * Service provider for the RouteArchitect package.
 *
 * @package TeaAroma\RouteArchitect
 */
class RouteArchitectServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([ __DIR__ . '/../Config/route-architect.php' => config_path('route-architect.php') ], 'config');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([ MakeRouteArchitect::class ]);
        }

        $this->mergeConfigFrom(__DIR__ . '/../Config/route-architect.php', 'route-architect');
    }
}
