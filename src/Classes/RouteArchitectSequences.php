<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Callables\FindSequenceEntryCallable;


/**
 * Implements logical sequences of the 'RouteArchitect' classes.
 */
class RouteArchitectSequences
{
    /**
     * The sequences.
     *
     * @var Collection<string, RouteArchitectSequenceEntry>
     */
    protected Collection $sequences;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->sequences = new Collection();
    }

    /**
     * Gets the sequences.
     *
     * @return Collection<string, RouteArchitectSequenceEntry>
     */
    public function getSequences(): Collection
    {
        return $this->sequences;
    }

    /**
     * Gets the sequence entry by the given sequence names.
     *
     * @param class-string<RouteArchitect>      $sequenceName
     * @param class-string<RouteArchitect>|null $sequenceGroupName
     *
     * @return RouteArchitectSequenceEntry|null
     */
    public function getSequence(string $sequenceName, ?string $sequenceGroupName = null): ?RouteArchitectSequenceEntry
    {
        return $this->sequences->first(new FindSequenceEntryCallable($sequenceName, $sequenceGroupName));
    }

    /**
     * Determines whether the sequence entry exists by the given sequence names.
     *
     * @param class-string<RouteArchitect>      $sequenceName
     * @param class-string<RouteArchitect>|null $sequenceGroupName
     *
     * @return bool
     */
    public function hasSequence(string $sequenceName, ?string $sequenceGroupName = null): bool
    {
        return $this->sequences->some(new FindSequenceEntryCallable($sequenceName, $sequenceGroupName));
    }

    /**
     * Determines whether the sequence entry by the given route name exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasSequenceByRouteName(string $name): bool
    {
        return $this->sequences->has($name);
    }

    /**
     * Adds the sequence entry by the given 'RouteArchitect' instance.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return void
     */
    public function addSequence(RouteArchitect $routeArchitect): void
    {
        if ($this->hasSequenceByRouteName($routeArchitect->getContext()->getName()))
        {
            return;
        }

        $entry = new RouteArchitectSequenceEntry($routeArchitect);

        $this->sequences->put($routeArchitect->getContext()->getName(), $entry);
    }
}