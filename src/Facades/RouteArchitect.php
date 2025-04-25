<?php

namespace TeaAroma\RouteArchitect\Facades;

use Illuminate\Support\Facades\Facade;
use TeaAroma\RouteArchitect\Services\RouteArchitectService;


/**
 * @method static string get_name_sequence(class-string<\TeaAroma\RouteArchitect\Abstracts\RouteArchitect> $namespace)
 * @method static string get_view_sequence(class-string<\TeaAroma\RouteArchitect\Abstracts\RouteArchitect> $namespace)
 * @method static void register(class-string<\TeaAroma\RouteArchitect\Abstracts\RouteArchitect> $namespace)
 *
 * @see RouteArchitectService
 */
class RouteArchitect extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'route-architect';
    }
}
