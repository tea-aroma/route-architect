<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;


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
     * Gets the sequence entry by the given instance.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return RouteArchitectSequenceEntry|null
     */
    public function getSequence(RouteArchitect $routeArchitect): ?RouteArchitectSequenceEntry
    {
        return $this->sequences->get($routeArchitect->getContext()->getName());
    }

    /**
     * Determines whether the sequence of the given instance is exits.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return bool
     */
    public function hasSequence(RouteArchitect $routeArchitect): bool
    {
        return $this->sequences->has($routeArchitect->getContext()->getName());
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
        if ($this->hasSequence($routeArchitect))
        {
            return;
        }

        $entry = new RouteArchitectSequenceEntry($routeArchitect);

        $this->sequences->put($routeArchitect->getContext()->getName(), $entry);
    }
}