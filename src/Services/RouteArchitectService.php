<?php

namespace TeaAroma\RouteArchitect\Services;


use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;


/**
 * Provides service methods for 'RouteArchitect' class.
 */
class RouteArchitectService
{
    /**
     * Gets the name of route by the given namespace.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return string
     */
    public function get_route_name(string $namespace): string
    {
        return (new $namespace())->get_name_sequence();
    }

    /**
     * Gets the name of view by the given namespace.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return string
     */
    public function get_view_name(string $namespace): string
    {
        return (new $namespace())->get_view_sequence();
    }

    /**
     * Registers the 'RouteArchitect' by the given namespace.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return void
     */
    public function register(string $namespace): void
    {
        (new $namespace())->register();
    }
}
