<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;


/**
 * Implements the core logic for registering routes.
 */
class RouteArchitectRegistrar
{
    /**
     * The instance of the 'RouteArchitect'.
     *
     * @var RouteArchitect
     */
    private RouteArchitect $routeArchitect;

    /**
     * The context of the 'Route'.
     *
     * @var RouteRegistrar|Router
     */
    private RouteRegistrar | Router $route;

    /**
     * @param RouteArchitect $routeArchitect
     */
    public function __construct(RouteArchitect $routeArchitect)
    {
        $this->routeArchitect = $routeArchitect;

        $this->route = new RouteRegistrar(Route::getFacadeRoot());
    }

    /**
     * Registers the route.
     *
     * @return void
     */
    public function register(): void
    {
        $this->nameProcessing();

        $this->middlewaresProcessing();

        $this->excludeMiddlewaresProcessing();

        $this->namespaceProcessing();

        $this->domainProcessing();

        $this->typeProcessing();

        $this->prefixProcessing();

        $this->controllerProcessing();

        $this->groupProcessing();
    }

    /**
     * Handles the process of the name.
     *
     * @return void
     */
    protected function nameProcessing(): void
    {
        $name = $this->routeArchitect->getName();

        if ($this->routeArchitect->hasNameSequence())
        {
            $name = RouteArchitectConfig::ROUTE_NAME_DELIMITER->getConfig() . $name;
        }

        $this->route->name($name);
    }

    /**
     * Handles the process of the middlewares.
     *
     * @return void
     */
    protected function middlewaresProcessing(): void
    {
        if (!$this->routeArchitect->hasMiddlewares())
        {
            return;
        }

        $this->route->middleware($this->routeArchitect->getMiddlewaresArray());
    }

    /**
     * Handles the process of the middlewares to exclude.
     *
     * @return void
     */
    protected function excludeMiddlewaresProcessing(): void
    {
        if (!$this->routeArchitect->hasExcludeMiddlewares())
        {
            return;
        }

        $this->route->withoutMiddleware($this->routeArchitect->getExcludeMiddlewaresArray());
    }

    /**
     * Handles the process of registration based on the type.
     *
     * @return void
     */
    protected function typeProcessing(): void
    {
        if ($this->routeArchitect->isGroup() && !$this->routeArchitect->hasAction())
        {
            return;
        }

        $this->route->{ $this->routeArchitect->getType()->value }($this->routeArchitect->getUrl(), $this->routeArchitect->getAction());
    }

    /**
     * Handles the process of the prefix.
     *
     * @return void
     */
    protected function prefixProcessing(): void
    {
        if (!$this->routeArchitect->isGroup())
        {
            return;
        }

        $this->route->prefix($this->routeArchitect->getPrefix());
    }

    /**
     * Handles the process of the controller.
     *
     * @return void
     */
    protected function controllerProcessing(): void
    {
        if (!$this->routeArchitect->hasController())
        {
            return;
        }

        $this->route->controller($this->routeArchitect->getController());
    }

    /**
     * Handles the process of the namespace.
     *
     * @return void
     */
    protected function namespaceProcessing(): void
    {
        $this->route->namespace($this->routeArchitect->getNamespace());
    }

    /**
     * Handles the process of the domain.
     *
     * @return void
     */
    protected function domainProcessing(): void
    {
        if (!$this->routeArchitect->hasDomain())
        {
            return;
        }

        $this->route->domain($this->routeArchitect->getDomain());
    }

    /**
     * Handles the process of the group.
     *
     * @return void
     */
    protected function groupProcessing(): void
    {
        if (!$this->routeArchitect->isGroup())
        {
            return;
        }

        $this->route->group($this->groupHandle( ... ));
    }

    /**
     * Handles the processing logic for a 'group' method of 'Route'.
     *
     * @param Router $router
     *
     * @return void
     */
    protected function groupHandle(Router $router): void
    {
        foreach ($this->routeArchitect->getRouteArchitects() as $routeArchitect)
        {
            /**
             * @var RouteArchitect $routeArchitect
             */
            $routeArchitect = new $routeArchitect();

            if ($routeArchitect->isPass())
            {
                continue;
            }

            $routeArchitect->addSequencesProcessing($this->routeArchitect);

            $routeArchitect->register();
        }
    }

    /**
     * Gets the instance of the 'RouteArchitect'.
     *
     * @return RouteArchitect
     */
    public function getRouteArchitect(): RouteArchitect
    {
        return $this->routeArchitect;
    }

    /**
     *  Gets the context of the 'Route'.
     *
     * @return RouteRegistrar|Router
     */
    public function getRoute(): RouteRegistrar | Router
    {
        return $this->route;
    }

    /**
     * Sets the given context of the 'Route'.
     *
     * @param RouteRegistrar|Router $route
     *
     * @return void
     */
    public function setRoute(RouteRegistrar | Router $route): void
    {
        $this->route = $route;
    }
}
