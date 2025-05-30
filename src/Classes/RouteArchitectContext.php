<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;


/**
 * Stores the trace of 'RouteArchitect' class registrations.
 */
class RouteArchitectContext
{
    /**
     * The route name, composed of the execution trace.
     *
     * @var string
     */
    protected string $name = '';

    /**
     * The view name, composed of the execution trace.
     *
     * @var string
     */
    protected string $view = '';

    /**
     * The prefix, composed of the execution trace.
     *
     * @var string
     */
    protected string $prefix = '';

    /**
     * The execution trace.
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
     * Clones the current instance.
     *
     * @return $this
     */
    public function clone(): RouteArchitectContext
    {
        $context = clone $this;

        $context->setTrace($this->getTrace(true));

        return $context;
    }

    /**
     * Merges the given 'RouteArchitect' instance.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return $this
     */
    public function mergeRouteArchitect(RouteArchitect $routeArchitect): static
    {
        $this->addName($routeArchitect->getName());

        $this->addView($routeArchitect->getView());

        $this->addPrefix($routeArchitect->getPrefix());

        $this->addTrace($routeArchitect);

        return $this;
    }

    /**
     * Gets the last instance of execution trace.
     *
     * @return RouteArchitect|null
     */
    public function getLastTrace(): ?RouteArchitect
    {
        return $this->trace->last();
    }

    /**
     * Gets the penultimate instance of the execution trace.
     *
     * @return RouteArchitect|null
     */
    public function getPenultimateTrace(): ?RouteArchitect
    {
        return $this->trace->get($this->trace->count() - 2);
    }

    /**
     * Determines whether the given instance is the first execution trace.
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
     * Gets the full route name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Adds the given route name.
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
     * Gets the full view name.
     *
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * Adds the given view name.
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
        $this->prefix .= ( $this->prefix ? RouteArchitectConfig::URL_DELIMITER->getConfig() : '' ) . $prefix;

        return $this;
    }

    /**
     * Gets the execution trace.
     *
     * @param bool $isClone
     *
     * @return Collection
     */
    public function getTrace(bool $isClone = false): Collection
    {
        return $isClone ? (clone $this->trace) : $this->trace;
    }

    /**
     * Sets the given execution trace.
     *
     * @param Collection $trace
     *
     * @return $this
     */
    public function setTrace(Collection $trace): static
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * Adds the given instance to the execution trace.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return static
     */
    public function addTrace(RouteArchitect $routeArchitect): static
    {
        $this->trace->push($routeArchitect);

        return $this;
    }
}
