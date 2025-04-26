<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;
use TeaAroma\RouteArchitect\Enums\RouteArchitectMethodNames;
use TeaAroma\RouteArchitect\Enums\RouteArchitectSequenceTypes;


/**
 * Implements logical sequences using namespaces of the 'RouteArchitect' class.
 */
class RouteArchitectSequences
{
    /**
     * The sequences.
     *
     * @var Collection<class-string<RouteArchitect>, string>
     */
    protected Collection $sequences;

    /**
     * The type.
     *
     * @var RouteArchitectSequenceTypes
     */
    protected RouteArchitectSequenceTypes $type;

    /**
     * Todo: Needs refactoring.
     *
     * The delimiter.
     *
     * @var RouteArchitectConfig
     */
    protected RouteArchitectConfig $delimiter = RouteArchitectConfig::ROUTE_NAME_DELIMITER;

    /**
     * @param RouteArchitectSequenceTypes $type
     */
    public function __construct(RouteArchitectSequenceTypes $type)
    {
        $this->sequences = new Collection();

        $this->type = $type;
    }

    /**
     * Gets the value for a sequence.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return string
     */
    public function getValue(RouteArchitect $routeArchitect): string
    {
        return $routeArchitect->{ $this->getMethodName()->value }();
    }

    /**
     * Gets the name of the method by the type.
     *
     * @return RouteArchitectMethodNames
     */
    protected function getMethodName(): RouteArchitectMethodNames
    {
        return match ($this->type->name)
        {
            RouteArchitectSequenceTypes::NAMES->name => RouteArchitectMethodNames::GET_NAME,
            RouteArchitectSequenceTypes::VIEWS->name => RouteArchitectMethodNames::GET_VIEW,
        };
    }

    /**
     * Gets the sequences.
     *
     * @return Collection
     */
    public function getSequences(): Collection
    {
        return $this->sequences;
    }

    /**
     * Gets the type.
     *
     * @return RouteArchitectSequenceTypes
     */
    public function getType(): RouteArchitectSequenceTypes
    {
        return $this->type;
    }

    /**
     * Sets the given type.
     *
     * @param RouteArchitectSequenceTypes $type
     *
     * @return void
     */
    public function setType(RouteArchitectSequenceTypes $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets the delimiter.
     *
     * @return RouteArchitectConfig
     */
    public function getDelimiter(): RouteArchitectConfig
    {
        return $this->delimiter;
    }

    /**
     * Sets the given delimiter.
     *
     * @param RouteArchitectConfig $delimiter
     *
     * @return void
     */
    public function setDelimiter(RouteArchitectConfig $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Gets the sequence by the given instance.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return string|null
     */
    public function getSequence(RouteArchitect $routeArchitect): string | null
    {
        return $this->sequences->get($routeArchitect->getClassname());
    }

    /**
     * Gets the sequence by the given namespace.
     *
     * @param string $namespace
     *
     * @return string|null
     */
    public function getSequenceByNamespace(string $namespace): string | null
    {
        return $this->sequences->get($namespace);
    }

    /**
     * Determines whether the sequence by the given instance exists.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return bool
     */
    public function hasSequence(RouteArchitect $routeArchitect): bool
    {
        return $this->sequences->has($routeArchitect->getClassname());
    }

    /**
     * Determines whether the sequence by the given namespace exists.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return bool
     */
    public function hasSequenceByNamespace(string $namespace): bool
    {
        return $this->sequences->has($namespace);
    }

    /**
     * Appends the base sequence by the given instance.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return void
     */
    private function addBaseSequence(RouteArchitect $routeArchitect): void
    {
        if ($this->hasSequence($routeArchitect))
        {
            return;
        }

        $this->sequences->put($routeArchitect->getClassname(), $this->getValue($routeArchitect));
    }

    /**
     * Appends the sequence by the given instances.
     *
     * @param RouteArchitect $routeArchitect
     * @param RouteArchitect $nestedRouteArchitect
     *
     * @return void
     */
    public function addSequence(RouteArchitect $routeArchitect, RouteArchitect $nestedRouteArchitect): void
    {
        $this->addBaseSequence($routeArchitect);

        $this->sequences->put($nestedRouteArchitect->getClassname(), $this->getSequence($routeArchitect) . $this->delimiter->getConfig() . $this->getValue($nestedRouteArchitect));
    }
}