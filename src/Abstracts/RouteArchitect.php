<?php

namespace TeaAroma\RouteArchitect\Abstracts;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Classes\RouteArchitectMiddlewares;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequences;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;
use TeaAroma\RouteArchitect\Enums\RouteArchitectErrors;
use TeaAroma\RouteArchitect\Enums\RouteArchitectSequenceTypes;
use TeaAroma\RouteArchitect\Enums\RouteArchitectTypes;
use TeaAroma\RouteArchitect\Helpers\RouteArchitectHelpers;


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
     * The prefix.
     *
     * @var string|null
     */
    protected ?string $prefix = null;

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
     * The custom url.
     *
     * @var string|null
     */
    protected ?string $custom_url = null;

    /**
     * The middleware(s).
     *
     * @var class-string[]
     */
    protected array $middlewares = [];

    /**
     * The manager of the middleware(s).
     *
     * @var RouteArchitectMiddlewares
     */
    private RouteArchitectMiddlewares $middlewares_manager;

    /**
     * The middlewares to exclude.
     *
     * @var class-string[]
     */
    protected array $exclude_middlewares = [];

    /**
     * The manager of the middlewares to exclude.
     *
     * @var RouteArchitectMiddlewares
     */
    private RouteArchitectMiddlewares $exclude_middlewares_manager;

    /**
     * The 'RouteArchitect' classes.
     *
     * @var class-string<RouteArchitect>[]
     */
    protected array $route_architects = [];

    /**
     * The variables.
     *
     * @var string[]
     */
    protected array $variables = [];

    /**
     * The sequences of names.
     *
     * @var RouteArchitectSequences
     */
    static protected RouteArchitectSequences $name_sequences;

    /**
     * The sequences of views.
     *
     * @var RouteArchitectSequences
     */
    static protected RouteArchitectSequences $view_sequences;

    /**
     * The constructor.
     */
    public function __construct()
    {
        self::$name_sequences ??= new RouteArchitectSequences(RouteArchitectSequenceTypes::NAMES);

        self::$view_sequences ??= new RouteArchitectSequences(RouteArchitectSequenceTypes::VIEWS);

        $this->middlewares_manager ??= new RouteArchitectMiddlewares($this->middlewares);

        $this->exclude_middlewares_manager ??= new RouteArchitectMiddlewares($this->exclude_middlewares);
    }

    /**
     * Defines and registers the route.
     *
     * @return void
     */
    public function register(): void {}

    /**
     * Callback method to be executed when property 'action' is null.
     *
     * @return void
     */
    protected function handle(): void
    {
        throw new \LogicException(RouteArchitectErrors::METHOD_NOT_OVERIDE->format(__FUNCTION__, static::class));
    }

    /**
     * Gets the 'Closure' of the 'handle' method.
     *
     * @return \Closure
     */
    public function get_handle(): \Closure
    {
        return RouteArchitectHelpers::get_closure($this, 'handle');
    }

    /**
     * Gets the url.
     *
     * @return string
     */
    public function get_url(): string
    {
        if ($this->has_custom_url())
        {
            return $this->get_custom_url();
        }

        $url_delimiter = RouteArchitectConfig::URL_DELIMITER->get_config();

        $route_name_delimiter = RouteArchitectConfig::ROUTE_NAME_DELIMITER->get_config();

        $regular_expression = '/' . addcslashes($route_name_delimiter, $route_name_delimiter) . '/';

        return $url_delimiter . preg_replace($regular_expression, $url_delimiter, $this->get_name());
    }

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
     * Determines whether the identifier exists.
     *
     * @return bool
     */
    public function has_identifier(): bool
    {
        return !empty($this->identifier);
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
     * Determines whether the name of route exists.
     *
     * @return bool
     */
    public function has_name(): bool
    {
        return !empty($this->name);
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
     * Determines whether the name of view exists.
     *
     * @return bool
     */
    public function has_view(): bool
    {
        return !empty($this->view);
    }

    /**
     * Gets the prefix.
     *
     * If the property 'prefix' is empty - the 'identifier' property will be returned.
     *
     * @return string
     */
    public function get_prefix(): string
    {
        return $this->prefix ?? $this->identifier;
    }

    /**
     * Sets the given prefix.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function set_prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Determines whether the prefix exists.
     *
     * @return bool
     */
    public function has_prefix(): bool
    {
        return !empty($this->prefix);
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
     * Determines whether the type exists.
     *
     * @return bool
     */
    public function has_type(): bool
    {
        return !empty($this->type);
    }

    /**
     * Gets the action.
     *
     * @return array<class-string, string>|string|callable
     */
    public function get_action(): array | string | callable
    {
        if (!$this->has_action())
        {
            return $this->get_handle();
        }

        if ($this->has_controller() && is_string($this->action))
        {
            return $this->get_controller() . RouteArchitectConfig::ACTION_DELIMITER->get_config() . $this->action;
        }

        return $this->action;
    }

    /**
     * Sets the given action.
     *
     * @param array<class-string, string>|string $action
     *
     * @return static
     */
    public function set_action(array | string $action): static
    {
        $this->action = $action;

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
     * Gets the class name of constructor.
     *
     * @return string|null
     */
    public function get_controller(): ?string
    {
        return $this->controller;
    }

    /**
     * Sets the given class name of constructor.
     *
     * @param string $controller
     *
     * @return static
     */
    public function set_controller(string $controller): static
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Determines whether the controller exists.
     *
     * @return bool
     */
    public function has_controller(): bool
    {
        return !empty($this->controller);
    }

    /**
     * Gets the custom url.
     *
     * @return string|null
     */
    public function get_custom_url(): ?string
    {
        return $this->custom_url;
    }

    /**
     * Sets the given custom url.
     *
     * @param string $custom_url
     *
     * @return static
     */
    public function set_custom_url(string $custom_url): static
    {
        $this->custom_url = $custom_url;

        return $this;
    }

    /**
     * Determines whether the custom url exists.
     *
     * @return bool
     */
    public function has_custom_url(): bool
    {
        return !empty($this->custom_url);
    }

    /**
     * Gets the middlewares.
     *
     * @return Collection<class-string>
     */
    public function get_middlewares(): Collection
    {
        return $this->middlewares_manager->get_middlewares();
    }

    /**
     * Gets the array of the middlewares.
     *
     * @return class-string[]
     */
    public function get_middlewares_array(): array
    {
        return $this->middlewares_manager->to_array();
    }

    /**
     * Sets the given middlewares.
     *
     * @param Collection<class-string> $middlewares
     *
     * @return static
     */
    public function set_middlewares(Collection $middlewares): static
    {
        $this->middlewares_manager->set_middlewares($middlewares);

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
        $this->middlewares_manager->add_middlewares($middleware);

        return $this;
    }

    /**
     * Determines whether there are any middlewares.
     *
     * @return bool
     */
    public function has_middlewares(): bool
    {
        return !$this->middlewares_manager->is_empty();
    }

    /**
     * Gets the middlewares to exclude.
     *
     * @return Collection<class-string>
     */
    public function get_exclude_middlewares(): Collection
    {
        return $this->exclude_middlewares_manager->get_middlewares();
    }

    /**
     * Gets the array of the middlewares to exclude.
     *
     * @return class-string[]
     */
    public function get_exclude_middlewares_array(): array
    {
        return $this->exclude_middlewares_manager->to_array();
    }

    /**
     * Sets the given middlewares to exclude.
     *
     * @param Collection<class-string> $middlewares
     *
     * @return static
     */
    public function set_exclude_middlewares(Collection $middlewares): static
    {
        $this->exclude_middlewares_manager->set_middlewares($middlewares);

        return $this;
    }

    /**
     * Appends one or more middleware to exclude to the existing list.
     *
     * @param class-string[]|class-string $middleware
     *
     * @return static
     */
    public function add_exclude_middleware(array | string $middleware): static
    {
        $this->exclude_middlewares_manager->add_middlewares($middleware);

        return $this;
    }

    /**
     * Determines whether there are any middlewares to exclude.
     *
     * @return bool
     */
    public function has_exclude_middlewares(): bool
    {
        return !$this->exclude_middlewares_manager->is_empty();
    }

    /**
     * Gets the 'RouteArchitects' classes.
     *
     * @return string-class<RouteArchitect>[]
     */
    public function get_route_architects(): array
    {
        return $this->route_architects;
    }

    /**
     * Sets the given 'RouteArchitects' classes.
     *
     * @param class-string<RouteArchitect>[] $route_architects
     *
     * @return static
     */
    public function set_route_architects(array $route_architects): static
    {
        $this->route_architects = $route_architects;

        return $this;
    }

    /**
     * Appends one or more 'RouteArchitect' class to the existing list.
     *
     * @param class-string<RouteArchitect>[]|class-string<RouteArchitect> $route_architects
     *
     * @return static
     */
    public function add_route_architect(array | string $route_architects): static
    {
        $this->route_architects = array_merge($this->route_architects, (array) $route_architects);

        return $this;
    }

    /**
     * Determines whether there are any 'RouteArchitect' class.
     *
     * @return bool
     */
    public function has_route_architects(): bool
    {
        return !empty($this->route_architects);
    }

    /**
     * Gets the variables.
     *
     * @return string[]
     */
    public function get_variables(): array
    {
        return $this->variables;
    }

    /**
     * Sets the given variables.
     *
     * @param string[] $variables
     *
     * @return void
     */
    public function set_variables(array $variables): void
    {
        $this->variables = $variables;
    }

    /**
     * Appends one or more variable to the existing list.
     *
     * @param string[]|string $variables
     *
     * @return $this
     */
    public function add_variable(array | string $variables): static
    {
        $this->variables = array_merge($this->variables, (array) $variables);

        return $this;
    }

    /**
     * Determines whether there are any variables.
     *
     * @return bool
     */
    public function has_variables(): bool
    {
        return !empty($this->variables);
    }

    /**
     * Gets sequences of names.
     *
     * @return RouteArchitectSequences
     */
    public function get_name_sequences(): RouteArchitectSequences
    {
        return self::$name_sequences;
    }

    /**
     * Gets the sequence of the name.
     *
     * @return string|null
     */
    public function get_name_sequence(): string | null
    {
        return self::$name_sequences->get_sequence($this);
    }

    /**
     * Appends the sequence of the name.
     *
     * @param RouteArchitect $route_architect
     *
     * @return static
     */
    public function add_name_sequence(RouteArchitect $route_architect): static
    {
        self::$name_sequences->add_sequence($route_architect, $this);

        return $this;
    }

    /**
     * Determines whether the sequence of the name exists.
     *
     * @return bool
     */
    public function has_name_sequence(): bool
    {
        return self::$name_sequences->has_sequence($this);
    }

    /**
     * Gets sequences of views.
     *
     * @return RouteArchitectSequences
     */
    public function get_view_sequences(): RouteArchitectSequences
    {
        return self::$view_sequences;
    }

    /**
     * Gets the sequence of the view.
     *
     * @return string|null
     */
    public function get_view_sequence(): string | null
    {
        return self::$view_sequences->get_sequence($this);
    }

    /**
     * Appends one or more sequence of the view.
     *
     * @param RouteArchitect $route_architect
     *
     * @return static
     */
    public function add_view_sequence(RouteArchitect $route_architect): static
    {
        self::$view_sequences->add_sequence($route_architect, $this);

        return $this;
    }

    /**
     * Determines whether the sequence of the view exists.
     *
     * @return bool
     */
    public function has_view_sequence(): bool
    {
        return self::$view_sequences->has_sequence($this);
    }

    /**
     * Implements the process of appending sequences by the given instance.
     *
     * @param RouteArchitect $route_architect
     *
     * @return static
     */
    public function add_sequences_processing(RouteArchitect $route_architect): static
    {
        self::add_name_sequence($route_architect);

        self::add_view_sequence($route_architect);

        return $this;
    }

    /**
     * Gets the namespace.
     *
     * @return string
     */
    public function get_namespace(): string
    {
        return $this::class;
    }

    /**
     * Determines whether the current instance is a group.
     *
     * @return string
     */
    public function is_group(): string
    {
        return $this->has_route_architects();
    }
}
