<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;
use TeaAroma\RouteArchitect\Helpers\RouteArchitectHelpers;


/**
 * Implements work with sequences of 'RouteArchitect' instances.
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
     *
     */
    public function __construct()
    {
        $this->sequences = new Collection();
    }

    /**
     * Gets the sequences.
     *
     * @return Collection<class-string<RouteArchitect>, string>
     */
    public function get_sequences(): Collection
    {
        return $this->sequences;
    }

    /**
     * Gets the sequence by the given 'RouteArchitect' instance.
     *
     * @param RouteArchitect $route_architect
     *
     * @return string
     */
    public function get_sequence(RouteArchitect $route_architect): string
    {
        return $this->sequences->get($route_architect->get_namespace()) ?? '';
    }

    /**
     * Gets the sequence by the given 'RouteArchitect' namespace.
     *
     * @param class-string<RouteArchitect> $route_architect
     *
     * @return string
     */
    public function get_sequence_by_namespace(string $route_architect): string
    {
        return $this->sequences->get($route_architect) ?? '';
    }

    /**
     * Determines whether the sequence of the given 'RouteArchitect' instance exists.
     *
     * @param RouteArchitect $route_architect
     *
     * @return string
     */
    public function has_sequence(RouteArchitect $route_architect): string
    {
        return $this->sequences->has($route_architect->get_namespace());
    }

    /**
     * Appends the base sequence by the given 'RouteArchitect' instance.
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

        $this->sequences->put($route_architect->get_namespace(), $route_architect->get_name());
    }

    /**
     * Appends the sequence by the given 'RouteArchitect' instances.
     *
     * @param RouteArchitect $route_architect
     * @param RouteArchitect $nested_route_architect
     *
     * @return void
     */
    public function add_sequence(RouteArchitect $route_architect, RouteArchitect $nested_route_architect): void
    {
        $this->add_base_sequence($route_architect);

        $route_name_delimiter = RouteArchitectHelpers::get_config(RouteArchitectConfig::ROUTE_NAME_DELIMITER);

        $this->sequences->put($nested_route_architect->get_namespace(), $this->get_sequence($route_architect) . $route_name_delimiter . $nested_route_architect->get_name());
    }
}
