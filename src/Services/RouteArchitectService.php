<?php

namespace TeaAroma\RouteArchitect\Services;


use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\AutoScanner\RouteArchitectAutoScanner;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequenceEntry;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequences;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;


/**
 * Provides service methods for 'RouteArchitect' class.
 */
class RouteArchitectService
{
    /**
     * Gets the sequence entries.
     *
     * @return RouteArchitectSequences
     */
    public function getSequences(): RouteArchitectSequences
    {
        return RouteArchitect::getSequences();
    }

    /**
     * Gets the sequence entry by the given sequence names.
     *
     * @param class-string<RouteArchitect>      $sequenceName
     * @param class-string<RouteArchitect>|null $sequenceGroupName
     *
     * @return RouteArchitectSequenceEntry|null
     */
    public function getSequenceEntry(string $sequenceName, ?string $sequenceGroupName = null): ?RouteArchitectSequenceEntry
    {
        return RouteArchitect::getSequences()->getSequence($sequenceName, $sequenceGroupName);
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
