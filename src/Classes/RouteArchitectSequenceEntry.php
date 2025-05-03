<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;


/**
 * Represents a single sequence 'RouteArchitect' class entry.
 */
readonly class RouteArchitectSequenceEntry
{
    /**
     * The name of the current sequence.
     *
     * @var string
     */
    public string $sequence_name;

    /**
     * The group name of the current sequence.
     *
     * @var string
     */
    public string $sequence_group_name;

    /**
     * The instance of 'RouteArchitect' class.
     *
     * @var RouteArchitect
     */
    public RouteArchitect $routeArchitect;

    /**
     * The previously called instance of 'RouteArchitect' class.
     *
     * @var RouteArchitect|null
     */
    public ?RouteArchitect $calledRouteArchitect;

    /**
     * The route name.
     *
     * @var string
     */
    public string $name;

    /**
     * The view name.
     *
     * @var string
     */
    public string $view;

    /**
     * The prefix.
     *
     * @var string
     */
    public string $prefix;

    /**
     * The execution trace.
     *
     * @var Collection<RouteArchitect>
     */
    public Collection $trace;

    /**
     * @param RouteArchitect $routeArchitect
     */
    public function __construct(RouteArchitect $routeArchitect)
    {
        $this->routeArchitect = $routeArchitect;

        $context = $routeArchitect->getContext();

        $this->calledRouteArchitect = $context->getPenultimateTrace();

        $this->sequence_name = $routeArchitect->getClassname();

        $this->sequence_group_name = $routeArchitect->getSequencesGroupName();

        $this->name = $context->getName();

        $this->view = $context->getView();

        $this->prefix = $context->getPrefix();

        $this->trace = $context->getTrace();
    }
}
