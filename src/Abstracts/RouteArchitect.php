<?php

namespace TeaAroma\RouteArchitect\Abstracts;


use TeaAroma\RouteArchitect\Enums\RouteArchitectTypes;


/**
 * Abstract base class for building structured and expressive route definitions.
 */
abstract class RouteArchitect
{
    /**
     * The unique identifier.
     *
     * @var string
     */
    protected string $identifier;

    /**
     * The name of route.
     *
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * The name of view.
     *
     * @var string|null
     */
    protected ?string $view = null;

    /**
     * The type of method.
     *
     * @var RouteArchitectTypes
     */
    protected RouteArchitectTypes $type = RouteArchitectTypes::GET;

    /**
     * The action.
     *
     * @var array<class-string, string>|string
     */
    protected array | string | null $action = null;

    /**
     * The class name of controller.
     *
     * @var class-string|null
     */
    protected ?string $controller = null;

    /**
     * The middleware(s).
     *
     * @var class-string[]|class-string|null
     */
    protected array | string | null $middlewares = null;

    /**
     * The middleware(s) to ignore.
     *
     * @var class-string[]|class-string|null
     */
    protected array | string | null $ignore_middlewares = null;

    /**
     * The constructor.
     */
    public function __construct() {}

    /**
     * Defines and registers the route.
     *
     * @return void
     */
    public function declare(): void {}

    /**
     * Callback method to be executed when property 'action' is null.
     *
     * @return void
     */
    protected function callable(): void {}

    /**
     * Gets the identifier.
     *
     * @return string
     */
    public function get_identifier(): string
    {
        return $this->identifier;
    }

    /**
     * Sets the given identifier.
     *
     * @param string $identifier
     *
     * @return static
     */
    public function set_identifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Gets the name of route.
     *
     * If the property 'name' is null - the 'identifier' property will be returned.
     *
     * @return string
     */
    public function get_name(): string
    {
        return $this->name ?? $this->identifier;
    }

    /**
     * Sets the given name of route.
     *
     * @param string $name
     *
     * @return static
     */
    public function set_name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the name of view.
     *
     * If the property 'view_name' is empty - the 'identifier' property will be returned.
     *
     * @return string
     */
    public function get_view(): string
    {
        return $this->view ?? $this->identifier;
    }

    /**
     * Sets the given name of view.
     *
     * @param string $view
     *
     * @return static
     */
    public function set_view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Gets the type of method.
     *
     * @return RouteArchitectTypes
     */
    public function get_type(): RouteArchitectTypes
    {
        return $this->type;
    }

    /**
     * Sets the given type of method.
     *
     * @param RouteArchitectTypes $type
     *
     * @return $this
     */
    public function set_type(RouteArchitectTypes $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Gets the action.
     *
     * @return array<class-string, string>|string|null
     */
    public function get_action(): array | string | null
    {
        return $this->action;
    }

    /**
     * Sets the given action.
     *
     * @param array<class-string, string>|string $action
     *
     * @return void
     */
    public function set_action(array | string $action): void
    {
        $this->action = $action;
    }

    /**
     * Gets the middleware(s).
     *
     * @return class-string|class-string[]|null
     */
    public function get_middlewares(): array | string | null
    {
        return $this->middlewares;
    }

    /**
     * Sets the given middleware(s).
     *
     * @param class-string[]|class-string $middlewares
     *
     * @return static
     */
    public function set_middlewares(array | string $middlewares): static
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /**
     * Appends one or more middleware to the existing list.
     *
     * @param class-string[]|class-string $middleware
     *
     * @return static
     */
    public function add_middleware(array | string $middleware): static
    {
        if (!$this->has_middlewares())
        {
            $this->middlewares = $middleware;

            return $this;
        }

        if (is_array($this->middlewares))
        {
            $this->middlewares = array_merge($this->middlewares, (array) $middleware);

            return $this;
        }

        if (is_string($this->middlewares))
        {
            $this->middlewares = [ $this->middlewares, ...( (array) $middleware ) ];
        }

        return $this;
    }

    /**
     * Gets the middleware(s) to ignore.
     *
     * @return class-string[]|class-string|null
     */
    public function get_ignore_middlewares(): array | string | null
    {
        return $this->ignore_middlewares;
    }

    /**
     * Sets the given middleware(s) to ignore.
     *
     * @param class-string[]|class-string $ignore_middlewares
     *
     * @return static
     */
    public function set_ignore_middlewares(array | string $ignore_middlewares): static
    {
        $this->ignore_middlewares = $ignore_middlewares;

        return $this;
    }

    /**
     * Appends one or more middleware to ignore to the existing list.
     *
     * @param class-string[]|class-string $middleware
     *
     * @return static
     */
    public function add_ignore_middleware(array | string $middleware): static
    {
        if (!$this->has_ignore_middlewares())
        {
            $this->ignore_middlewares = $middleware;

            return $this;
        }

        if (is_array($this->ignore_middlewares))
        {
            $this->ignore_middlewares = array_merge($this->ignore_middlewares, (array) $middleware);

            return $this;
        }

        if (is_string($this->ignore_middlewares))
        {
            $this->ignore_middlewares = [ $this->ignore_middlewares, ...( (array) $middleware ) ];
        }

        return $this;
    }

    /**
     * Determines whether there an action.
     *
     * @return bool
     */
    public function has_action(): bool
    {
        return !empty($this->action);
    }

    /**
     * Determines whether there are any middlewares for this route.
     *
     * @return bool
     */
    public function has_middlewares(): bool
    {
        return !empty($this->middlewares);
    }

    /**
     * Determines whether there are any middlewares to ignore for this route.
     *
     * @return bool
     */
    public function has_ignore_middlewares(): bool
    {
        return !empty($this->ignore_middlewares);
    }
}
