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
    private RouteArchitect $route_architect;

    /**
     * The context of the 'Route'.
     *
     * @var RouteRegistrar|Router
     */
    private RouteRegistrar | Router $route;

    /**
     * @param RouteArchitect $route_architect
     */
    public function __construct(RouteArchitect $route_architect)
    {
        $this->route_architect = $route_architect;

        $this->route = new RouteRegistrar(Route::getFacadeRoot());
    }

    /**
     * Registers the route.
     *
     * @return void
     */
    public function register(): void
    {
        $this->name_processing();

        $this->middlewares_processing();

        $this->exclude_middlewares_processing();

        $this->type_processing();

        $this->prefix_processing();

        $this->controller_processing();

        $this->group_processing();
    }

    /**
     * Handles the process of the name.
     *
     * @return void
     */
    protected function name_processing(): void
    {
        $name = $this->route_architect->get_name();

        if ($this->route_architect->has_name_sequence())
        {
            $name = RouteArchitectConfig::ROUTE_NAME_DELIMITER->get_config() . $name;
        }

        $this->route->name($name);
    }

    /**
     * Handles the process of the middlewares.
     *
     * @return void
     */
    protected function middlewares_processing(): void
    {
        if (!$this->route_architect->has_middlewares())
        {
            return;
        }

        $this->route->middleware($this->route_architect->get_middlewares_array());
    }

    /**
     * Handles the process of the middlewares to exclude.
     *
     * @return void
     */
    protected function exclude_middlewares_processing(): void
    {
        if (!$this->route_architect->has_exclude_middlewares())
        {
            return;
        }

        $this->route->withoutMiddleware($this->route_architect->get_exclude_middlewares_array());
    }

    /**
     * Handles the process of registration based on the type.
     *
     * @return void
     */
    protected function type_processing(): void
    {
        if ($this->route_architect->is_group() && !$this->route_architect->has_action())
        {
            return;
        }

        $this->route->{ $this->route_architect->get_type()->value }($this->route_architect->get_url(), $this->route_architect->get_action());
    }

    /**
     * Handles the process of the prefix.
     *
     * @return void
     */
    protected function prefix_processing(): void
    {
        if (!$this->route_architect->is_group())
        {
            return;
        }

        $this->route->prefix($this->route_architect->get_prefix());
    }

    /**
     * Handles the process of the controller.
     *
     * @return void
     */
    protected function controller_processing(): void
    {
        if (!$this->route_architect->has_controller())
        {
            return;
        }

        $this->route->controller($this->route_architect->get_controller());
    }

    /**
     * Handles the process of the namespace.
     *
     * @return void
     */
    protected function namespace_processing(): void
    {
        $this->route->namespace($this->route_architect->get_namespace());
    }

    /**
     * Handles the process of the domain.
     *
     * @return void
     */
    protected function domain_processing(): void
    {
        $this->route->domain($this->route_architect->get_domain());
    }

    /**
     * Handles the process of the group.
     *
     * @return void
     */
    protected function group_processing(): void
    {
        if (!$this->route_architect->is_group())
        {
            return;
        }

        $this->route->group($this->group_handle( ... ));
    }

    /**
     * Handles the processing logic for a 'group' method of 'Route'.
     *
     * @param Router $router
     *
     * @return void
     */
    protected function group_handle(Router $router): void
    {
        foreach ($this->route_architect->get_route_architects() as $route_architect)
        {
            /**
             * @var RouteArchitect $route_architect
             */
            $route_architect = new $route_architect();

            $route_architect->add_sequences_processing($this->route_architect);

            $route_architect->register();
        }
    }

    /**
     * Gets the instance of the 'RouteArchitect'.
     *
     * @return RouteArchitect
     */
    public function get_route_architect(): RouteArchitect
    {
        return $this->route_architect;
    }

    /**
     *  Gets the context of the 'Route'.
     *
     * @return RouteRegistrar|Router
     */
    public function get_route(): RouteRegistrar | Router
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
    public function set_route(RouteRegistrar | Router $route): void
    {
        $this->route = $route;
    }
}
