<?php

namespace TeaAroma\RouteArchitect\Abstracts;


use Illuminate\Support\Facades\Log;
use TeaAroma\RouteArchitect\Classes\RouteArchitectSequences;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;
use TeaAroma\RouteArchitect\Enums\RouteArchitectErrors;
use TeaAroma\RouteArchitect\Enums\RouteArchitectSequenceTypes;
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
    protected function callable(): void
    {
		throw new \LogicException(RouteArchitectErrors::METHOD_NOT_OVERIDE->format(__FUNCTION__, static::class));
    }
	
	/**
	 * Gets the 'Closure' of the 'callable' method.
	 *
	 * @return \Closure
	 */
	public function get_callable(): \Closure
	{
		try
		{
			$closure = (new \ReflectionMethod($this, 'callable'))->getClosure($this);
		}
		catch (\ReflectionException $exception)
		{
			Log::error(RouteArchitectErrors::UNDEFINED_CLOSURE->format(__FUNCTION__), [ 'exception' => $exception ]);
			
			$closure = fn () => null;
		}
		
		return $closure;
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
     * @return array<class-string, string>|string|null
     */
    public function get_action(): array | string | null
    {
		if (!$this->has_action())
		{
			return null;
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
	 * Determines whether there are any middlewares.
	 *
	 * @return bool
	 */
	public function has_middlewares(): bool
	{
		return !empty($this->middlewares);
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
	 * Determines whether there are any middlewares to ignore.
	 *
	 * @return bool
	 */
	public function has_ignore_middlewares(): bool
	{
		return !empty($this->ignore_middlewares);
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
	public static function get_name_sequences(): RouteArchitectSequences
	{
		return self::$name_sequences;
	}
	
	/**
	 * Gets sequences of views.
	 *
	 * @return RouteArchitectSequences
	 */
	public static function get_view_sequences(): RouteArchitectSequences
	{
		return self::$view_sequences;
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
