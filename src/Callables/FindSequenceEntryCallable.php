<?php

namespace TeaAroma\RouteArchitect\Callables;


use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequenceEntry;


/**
 * Finds a sequence entry by name and optional group name.
 */
readonly class FindSequenceEntryCallable
{
    /**
     * The sequence name to match.
     *
     * @var class-string<RouteArchitect>
     */
    public string $sequenceName;

    /**
     * The optional group name to match.
     *
     * @var class-string<RouteArchitect>|null
     */
    public ?string $sequenceGroupName;

    /**
     * @param class-string<RouteArchitect>      $sequenceName
     * @param class-string<RouteArchitect>|null $sequenceGroupName
     */
    public function __construct(string $sequenceName, ?string $sequenceGroupName)
    {
        $this->sequenceName = $sequenceName;

        $this->sequenceGroupName = $sequenceGroupName;
    }

    /**
     * Returns true if entry matches the sequence and group name.
     *
     * @param RouteArchitectSequenceEntry $entry
     *
     * @return bool
     */
    public function __invoke(RouteArchitectSequenceEntry $entry): bool
    {
        return $this->sequenceName === $entry->sequenceName && (is_null($this->sequenceGroupName) || $this->sequenceGroupName === $entry->sequencesGroupName);
    }
}
