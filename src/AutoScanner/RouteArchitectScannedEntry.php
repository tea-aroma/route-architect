<?php

namespace TeaAroma\RouteArchitect\AutoScanner;


use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectRegisterModes;
use TeaAroma\RouteArchitect\Traits\RouteArchitectRegisterMode;


/**
 * Represents a single scanned 'RouteArchitect' class entry.
 */
class RouteArchitectScannedEntry
{
    use RouteArchitectRegisterMode;

    /**
     * The instance of 'RouteArchitect'.
     *
     * @var RouteArchitect
     */
    readonly public RouteArchitect $routeArchitect;

    /**
     * @param class-string<RouteArchitect> $namespace
     */
    public function __construct(string $namespace)
    {
        $this->routeArchitect = new $namespace();
    }

    /**
     * Registers the 'RouteArchitect' class.
     *
     * @return void
     */
    public function register(): void
    {
        $this->routeArchitect->register();
    }

    /**
     * @inheritDoc
     *
     * @return RouteArchitectRegisterModes
     */
    public function getRegisterMode(): RouteArchitectRegisterModes
    {
        return $this->routeArchitect->getAutoScanRegisterMode() ?? $this->registerMode;
    }
}
