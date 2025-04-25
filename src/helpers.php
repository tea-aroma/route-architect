<?php

use TeaAroma\RouteArchitect\Services\RouteArchitectService;


if (! function_exists('route_architect')) {
    /**
     * Gets the 'RouteArchitectService' instance.
     *
     * @return RouteArchitectService
     */
    function route_architect(): RouteArchitectService
    {
        return app(RouteArchitectService::class);
    }
}
