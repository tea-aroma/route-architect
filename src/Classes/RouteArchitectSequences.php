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
     * @param RouteArchitect $route_architect
     *
     * @return string
     */
    public function get_value(RouteArchitect $route_architect): string
    {
        return $route_architect->{ $this->get_method_name()->value }();
    }

    /**
     * Gets the name of the method by the type.
     *
     * @return RouteArchitectMethodNames
     */
    protected function get_method_name(): RouteArchitectMethodNames
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
    public function get_sequences(): Collection
    {
        return $this->sequences;
    }

    /**
     * Gets the type.
     *
     * @return RouteArchitectSequenceTypes
     */
    public function get_type(): RouteArchitectSequenceTypes
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
    public function set_type(RouteArchitectSequenceTypes $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets the delimiter.
     *
     * @return RouteArchitectConfig
     */
    public function get_delimiter(): RouteArchitectConfig
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
    public function set_delimiter(RouteArchitectConfig $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Gets the sequence by the given instance.
     *
     * @param RouteArchitect $route_architect
     *
     * @return string|null
     */
    public function get_sequence(RouteArchitect $route_architect): string | null
    {
        return $this->sequences->get($route_architect->get_classname());
    }

    /**
     * Gets the sequence by the given namespace.
     *
     * @param string $namespace
     *
     * @return string|null
     */
    public function get_sequence_by_namespace(string $namespace): string | null
    {
        return $this->sequences->get($namespace);
    }

    /**
     * Determines whether the sequence by the given instance exists.
     *
     * @param RouteArchitect $route_architect
     *
     * @return bool
     */
    public function has_sequence(RouteArchitect $route_architect): bool
    {
        return $this->sequences->has($route_architect->get_classname());
    }

    /**
     * Determines whether the sequence by the given namespace exists.
     *
     * @param class-string<RouteArchitect> $namespace
     *
     * @return bool
     */
    public function has_sequence_by_namespace(string $namespace): bool
    {
        return $this->sequences->has($namespace);
    }

    /**
     * Appends the base sequence by the given instance.
     *
     * @param RouteArchitect $route_architect
     *
     * @return void
     */
    private function add_base_sequence(RouteArchitect $route_architect): void
    {
        if ($this->has_sequence($route_architect))
        {
            return;
        }

        $this->sequences->put($route_architect->get_classname(), $this->get_value($route_architect));
    }

    /**
     * Appends the sequence by the given instances.
     *
     * @param RouteArchitect $route_architect
     * @param RouteArchitect $nested_route_architect
     *
     * @return void
     */
    public function add_sequence(RouteArchitect $route_architect, RouteArchitect $nested_route_architect): void
    {
        $this->add_base_sequence($route_architect);

        $this->sequences->put($nested_route_architect->get_classname(), $this->get_sequence($route_architect) . $this->delimiter->get_config() . $this->get_value($nested_route_architect));
    }
}