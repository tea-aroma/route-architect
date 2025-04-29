<?php

namespace TeaAroma\RouteArchitect\Services;


use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\AutoScanner\RouteArchitectAutoScanner;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;


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

    /**
     * Automatically scans and registers all 'RouteArchitect' classes by the given force.
     *
     * @param bool $force
     *
     * @return void
     */
    public function autoScan(bool $force = true): void
    {
        if (!$force)
        {
            return;
        }

        $autoScan = new RouteArchitectAutoScanner(app_path(RouteArchitectConfig::DIRECTORY->getConfig()));

        $autoScan->initialization();
    }
}
