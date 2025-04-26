<?php

namespace TeaAroma\RouteArchitect\Helpers;


use TeaAroma\RouteArchitect\Callables\IsNotMiddleware;


/**
 * Provides utility methods for working with RouteArchitect logic.
 */
class RouteArchitectHelpers
{
    /**
     * Determines whether the given input is (or consists of) valid middleware.
     *
     * If input is an array, returns true only if all items are valid middleware.
     *
     * @param class-string|class-string[] $middleware
     *
     * @return bool
     */
    static public function is_middleware(string | array $middleware): bool
    {
        if (is_array($middleware))
        {
            if (empty($middleware))
            {
                return false;
            }

            $filter = array_filter($middleware, new IsNotMiddleware);

            return empty($filter);
        }

        return method_exists($middleware, 'handle');
    }
}
