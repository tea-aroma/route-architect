<?php

namespace TeaAroma\RouteArchitect\Facades;


use Illuminate\Support\Facades\Facade;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequenceEntry;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequences;
use TeaAroma\RouteArchitect\Services\RouteArchitectService;


/**
 * @method static RouteArchitectSequences getSequences()
 * @method static RouteArchitectSequenceEntry|null getSequenceEntry(class-string<\TeaAroma\RouteArchitect\Abstracts\RouteArchitect> $sequenceName, class-string<\TeaAroma\RouteArchitect\Abstracts\RouteArchitect>|null $sequenceGroupName)
 * @method static void register(class-string<\TeaAroma\RouteArchitect\Abstracts\RouteArchitect> $namespace)
 * @method static void autoScan(bool $force)
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
