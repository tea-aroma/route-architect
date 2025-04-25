<?php

use TeaAroma\RouteArchitect\Facades\RouteArchitect;
use TeaAroma\RouteArchitect\Services\RouteArchitectService;


if (! function_exists('route_architect')) {
    /**
     * Gets the 'RouteArchitectService' instance.
     *
     * @return RouteArchitectService
     */
    function route_architect(): \TeaAroma\RouteArchitect\Services\RouteArchitectService
    {
        return app(RouteArchitect::class);
    }
}
