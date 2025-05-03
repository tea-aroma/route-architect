<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;


/**
 * Accumulates values from trace of registering 'RouteArchitect' classes.
 */
class RouteArchitectContext
{
    /**
     * The name of route, composed of trace of the calls.
     *
     * @var string
     */
    protected string $name = '';

    /**
     * The name of view, composed of trace of the calls.
     *
     * @var string
     */
    protected string $view = '';

    /**
     * The prefix, composed of trace of the calls.
     *
     * @var string
     */
    protected string $prefix = '';

    /**
     * The trace of the calls.
     *
     * @var Collection<RouteArchitect>
     */
    protected Collection $trace;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->trace = new Collection();
    }

    /**
     * Gets the last instance of the trace of the calls.
     *
     * @return RouteArchitect|null
     */
    public function getLastTrace(): ?RouteArchitect
    {
        return $this->trace->last();
    }

    /**
     * Gets the penultimate instance of the trace of the calls.
     *
     * @return RouteArchitect|null
     */
    public function getPenultimateTrace(): ?RouteArchitect
    {
        return $this->trace->skip(1)->last();
    }

    /**
     * Determines whether the given instance is the first trace of the calls.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return bool
     */
    public function isFirstTrace(RouteArchitect $routeArchitect): bool
    {
        return $this->trace->first() === $routeArchitect;
    }

    /**
     * Gets the full name of the route.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Adds the given name of route.
     *
     * @param string $name
     *
     * @return static
     */
    public function addName(string $name): static
    {
        $this->name .= ( $this->name ? RouteArchitectConfig::ROUTE_NAME_DELIMITER->getConfig() : '' ) . $name;

        return $this;
    }

    /**
     * Gets the full name of the view.
     *
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * Adds the given name of view.
     *
     * @param string $view
     *
     * @return static
     */
    public function addView(string $view): static
    {
        $this->view .= ( $this->view ? RouteArchitectConfig::VIEW_NAME_DELIMITER->getConfig() : '' ) . $view;

        return $this;
    }

    /**
     * Gets the full prefix.
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Add the given prefix.
     *
     * @param string $prefix
     *
     * @return static
     */
    public function addPrefix(string $prefix): static
    {
        $this->prefix .= ( $this->view ? RouteArchitectConfig::URL_DELIMITER->getConfig() : '' ) . $prefix;

        return $this;
    }

    /**
     * Gets the trace of the calls.
     *
     * @return Collection
     */
    public function getTrace(): Collection
    {
        return $this->trace;
    }

    /**
     * Adds the given instance to the trace of the calls.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return static
     */
    public function addTrace(RouteArchitect $routeArchitect): static
    {
        $this->addName($routeArchitect->getName());

        $this->addView($routeArchitect->getView());

        $this->addPrefix($routeArchitect->getPrefix());

        $this->trace->push($routeArchitect);

        return $this;
    }
}
