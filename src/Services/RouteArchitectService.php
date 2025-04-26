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
    public function getRouteName(string $namespace): string
    {
        return (new $namespace())->getNameSequence();
    }

    /**
     * Gets the name of view by the given namespace.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return string
     */
    public function getViewName(string $namespace): string
    {
        return (new $namespace())->getViewSequence();
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
