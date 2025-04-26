<?php

namespace TeaAroma\RouteArchitect\Callables;


use TeaAroma\RouteArchitect\Helpers\RouteArchitectHelpers;


/**
 * Callable class used to filter out middleware classes from a list.
 */
class IsNotMiddleware
{
    /**
     * Determine whether the given class is not valid Laravel middleware.
     *
     * @param class-string $middleware
     *
     * @return string
     */
    public function __invoke(string $middleware): string
    {
        return !RouteArchitectHelpers::isMiddleware($middleware);
    }
}
