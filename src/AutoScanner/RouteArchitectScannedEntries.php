<?php

namespace TeaAroma\RouteArchitect\AutoScanner;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;


/**
 * Implements logical management for work with the 'RouteArchitectEntry' classes.
 */
readonly class RouteArchitectScannedEntries
{
    /**
     * The entries.
     *
     * @var Collection<class-string<RouteArchitect>, RouteArchitectScannedEntry>
     */
    protected Collection $entries;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->entries = new Collection();
    }

    /**
     * Gets the entries.
     *
     * @return Collection<class-string<RouteArchitect>, RouteArchitectScannedEntry>
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    /**
     * Gets the entry by the given namespace.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return RouteArchitectScannedEntry|null
     */
    public function getEntry(string $namespace): ?RouteArchitectScannedEntry
    {
        return $this->entries->get($namespace);
    }

    /**
     * Appends the given entry with the given key to the existing collection.
     *
     * @param class-string<RouteArchitect> $namespace
     * @param RouteArchitectScannedEntry   $entry
     *
     * @return void
     */
    public function addEntry(string $namespace, RouteArchitectScannedEntry $entry): void
    {
        $this->entries->put($namespace, $entry);
    }

    /**
     * Determines whether the entry with the given namespace exists.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return bool
     */
    public function hasEntry(string $namespace): bool
    {
        return $this->entries->has($namespace);
    }
}
