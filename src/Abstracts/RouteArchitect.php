<?php

namespace TeaAroma\RouteArchitect\Abstracts;


use Illuminate\Support\Collection;
use TeaAroma\RouteArchitect\Classes\RouteArchitectMiddlewares;
use TeaAroma\RouteArchitect\Classes\RouteArchitectRegistrar;
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
     * The url.
     *
     * @var string|null
     */
    protected ?string $url = null;

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
     * The namespace.
     *
     * @var class-string|null
     */
    protected ?string $namespace = null;

    /**
     * The domain.
     *
     * @var class-string|null
     */
    protected \BackedEnum | string | null $domain = null;

    /**
     * The custom url.
     *
     * @var string|null
     */
    protected ?string $customUrl = null;

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
    private RouteArchitectMiddlewares $middlewaresManager;

    /**
     * The middlewares to exclude.
     *
     * @var class-string[]
     */
    protected array $excludeMiddlewares = [];

    /**
     * The manager of the middlewares to exclude.
     *
     * @var RouteArchitectMiddlewares
     */
    private RouteArchitectMiddlewares $excludeMiddlewaresManager;

    /**
     * The 'RouteArchitect' classes.
     *
     * @var class-string<RouteArchitect>[]
     */
    protected array $routeArchitects = [];

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
    static protected RouteArchitectSequences $nameSequences;

    /**
     * The sequences of views.
     *
     * @var RouteArchitectSequences
     */
    static protected RouteArchitectSequences $viewSequences;

    /**
     * The constructor.
     */
    public function __construct()
    {
        self::$nameSequences ??= new RouteArchitectSequences(RouteArchitectSequenceTypes::NAMES);

        self::$viewSequences ??= new RouteArchitectSequences(RouteArchitectSequenceTypes::VIEWS);

        $this->middlewaresManager = new RouteArchitectMiddlewares($this->middlewares);

        $this->excludeMiddlewaresManager = new RouteArchitectMiddlewares($this->excludeMiddlewares);
    }

    /**
     * Defines and registers the route.
     *
     * @return void
     */
    public function register(): void
    {
        $registrar = new RouteArchitectRegistrar($this);

        $registrar->register();
    }

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
    public function getHandle(): \Closure
    {
        return $this->handle( ... );
    }

    /**
     * Normalizes a string to lowercase and joins its segments using the given delimiter.
     *
     * @param string $input
     * @param string $delimiter
     *
     * @return string
     */
    public function normalizeWithDelimiter(string $input, string $delimiter): string
    {
        $segments = preg_split('/[^a-z0-9]+/i', $input, flags: PREG_SPLIT_NO_EMPTY);

        return strtolower(implode($delimiter, $segments));
    }

    /**
     * Gets the identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
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
    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Determines whether the identifier exists.
     *
     * @return bool
     */
    public function hasIdentifier(): bool
    {
        return !empty($this->identifier);
    }

    /**
     * Gets the route name or identifier, normalized using the route name delimiter.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->normalizeWithDelimiter($this->name ?? $this->identifier, RouteArchitectConfig::ROUTE_NAME_DELIMITER->getConfig());
    }

    /**
     * Sets the given name of route.
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Determines whether the name of route exists.
     *
     * @return bool
     */
    public function hasName(): bool
    {
        return !empty($this->name);
    }

    /**
     * Gets the view name or identifier, normalized using the view name delimiter.
     *
     * @return string
     */
    public function getView(): string
    {
        return $this->normalizeWithDelimiter($this->view ?? $this->identifier, RouteArchitectConfig::VIEW_NAME_DELIMITER->getConfig());
    }

    /**
     * Sets the given name of view.
     *
     * @param string $view
     *
     * @return static
     */
    public function setView(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Determines whether the name of view exists.
     *
     * @return bool
     */
    public function hasView(): bool
    {
        return !empty($this->view);
    }

    /**
     * Gets the prefix or identifier, normalized using the URL segment delimiter.
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->normalizeWithDelimiter($this->prefix ?? $this->identifier, RouteArchitectConfig::URL_SEGMENT_DELIMITER->getConfig());
    }

    /**
     * Sets the given prefix.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Determines whether the prefix exists.
     *
     * @return bool
     */
    public function hasPrefix(): bool
    {
        return !empty($this->prefix);
    }

    /**
     * Gets the url or identifier, normalized using the URL segment delimiter.
     *
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->hasCustomUrl())
        {
            return $this->customUrl;
        }

        $urlDelimiter = RouteArchitectConfig::URL_DELIMITER->getConfig();

        $url = $this->url ?? $this->identifier;

        return $urlDelimiter . $url . $urlDelimiter . $this->getVariablesString();
    }

    /**
     * Sets the given url.
     *
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Determines whether the url exists.
     *
     * @return bool
     */
    public function hasUrl(): bool
    {
        return !empty($this->url);
    }

    /**
     * Gets the type of method.
     *
     * @return RouteArchitectTypes
     */
    public function getType(): RouteArchitectTypes
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
    public function setType(RouteArchitectTypes $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Determines whether the type exists.
     *
     * @return bool
     */
    public function hasType(): bool
    {
        return !empty($this->type);
    }

    /**
     * Gets the action.
     *
     * @return array<class-string, string>|string|callable
     */
    public function getAction(): array | string | callable
    {
        if (!$this->hasAction())
        {
            return $this->getHandle();
        }

        if ($this->hasController() && is_string($this->action))
        {
            return $this->getController() . RouteArchitectConfig::ACTION_DELIMITER->getConfig() . $this->action;
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
    public function setAction(array | string $action): static
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Determines whether there an action.
     *
     * @return bool
     */
    public function hasAction(): bool
    {
        return !empty($this->action);
    }

    /**
     * Gets the class name of constructor.
     *
     * @return string|null
     */
    public function getController(): ?string
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
    public function setController(string $controller): static
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Determines whether the controller exists.
     *
     * @return bool
     */
    public function hasController(): bool
    {
        return !empty($this->controller);
    }

    /**
     * Gets the namespace.
     *
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * Sets the given namespace.
     *
     * @param string $namespace
     *
     * @return static
     */
    public function setNamespace(string $namespace): static
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Determines whether the namespace exists.
     *
     * @return bool
     */
    public function hasNamespace(): bool
    {
        return !empty($this->namespace);
    }

    /**
     * Gets the domain as a string.
     *
     * @return string|null
     */
    public function getDomain(): string | null
    {
        if ($this->domain instanceof \BackedEnum)
        {
            return $this->domain->value;
        }

        return $this->domain;
    }

    /**
     * Sets the given domain.
     *
     * @param \BackedEnum|string $domain
     *
     * @return static
     */
    public function setDomain(\BackedEnum | string $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Determines whether the domain exists.
     *
     * @return bool
     */
    public function hasDomain(): bool
    {
        return !empty($this->domain);
    }

    /**
     * Gets the custom url.
     *
     * @return string|null
     */
    public function getCustomUrl(): ?string
    {
        return $this->customUrl;
    }

    /**
     * Sets the given custom url.
     *
     * @param string $customUrl
     *
     * @return static
     */
    public function setCustomUrl(string $customUrl): static
    {
        $this->customUrl = $customUrl;

        return $this;
    }

    /**
     * Determines whether the custom url exists.
     *
     * @return bool
     */
    public function hasCustomUrl(): bool
    {
        return !empty($this->customUrl);
    }

    /**
     * Gets the middlewares.
     *
     * @return Collection<class-string>
     */
    public function getMiddlewares(): Collection
    {
        return $this->middlewaresManager->getMiddlewares();
    }

    /**
     * Gets the array of the middlewares.
     *
     * @return class-string[]
     */
    public function getMiddlewaresArray(): array
    {
        return $this->middlewaresManager->toArray();
    }

    /**
     * Sets the given middlewares.
     *
     * @param Collection<class-string> $middlewares
     *
     * @return static
     */
    public function setMiddlewares(Collection $middlewares): static
    {
        $this->middlewaresManager->setMiddlewares($middlewares);

        return $this;
    }

    /**
     * Appends one or more middleware to the existing list.
     *
     * @param class-string[]|class-string $middleware
     *
     * @return static
     */
    public function addMiddleware(array | string $middleware): static
    {
        $this->middlewaresManager->addMiddlewares($middleware);

        return $this;
    }

    /**
     * Determines whether there are any middlewares.
     *
     * @return bool
     */
    public function hasMiddlewares(): bool
    {
        return !$this->middlewaresManager->isEmpty();
    }

    /**
     * Gets the middlewares to exclude.
     *
     * @return Collection<class-string>
     */
    public function getExcludeMiddlewares(): Collection
    {
        return $this->excludeMiddlewaresManager->getMiddlewares();
    }

    /**
     * Gets the array of the middlewares to exclude.
     *
     * @return class-string[]
     */
    public function getExcludeMiddlewaresArray(): array
    {
        return $this->excludeMiddlewaresManager->toArray();
    }

    /**
     * Sets the given middlewares to exclude.
     *
     * @param Collection<class-string> $middlewares
     *
     * @return static
     */
    public function setExcludeMiddlewares(Collection $middlewares): static
    {
        $this->excludeMiddlewaresManager->setMiddlewares($middlewares);

        return $this;
    }

    /**
     * Appends one or more middleware to exclude to the existing list.
     *
     * @param class-string[]|class-string $middleware
     *
     * @return static
     */
    public function addExcludeMiddleware(array | string $middleware): static
    {
        $this->excludeMiddlewaresManager->addMiddlewares($middleware);

        return $this;
    }

    /**
     * Determines whether there are any middlewares to exclude.
     *
     * @return bool
     */
    public function hasExcludeMiddlewares(): bool
    {
        return !$this->excludeMiddlewaresManager->isEmpty();
    }

    /**
     * Gets the 'RouteArchitects' classes.
     *
     * @return string-class<RouteArchitect>[]
     */
    public function getRouteArchitects(): array
    {
        return $this->routeArchitects;
    }

    /**
     * Sets the given 'RouteArchitects' classes.
     *
     * @param class-string<RouteArchitect>[] $routeArchitects
     *
     * @return static
     */
    public function setRouteArchitects(array $routeArchitects): static
    {
        $this->routeArchitects = $routeArchitects;

        return $this;
    }

    /**
     * Appends one or more 'RouteArchitect' class to the existing list.
     *
     * @param class-string<RouteArchitect>[]|class-string<RouteArchitect> $routeArchitects
     *
     * @return static
     */
    public function addRouteArchitect(array | string $routeArchitects): static
    {
        $this->routeArchitects = array_merge($this->routeArchitects, (array) $routeArchitects);

        return $this;
    }

    /**
     * Determines whether there are any 'RouteArchitect' class.
     *
     * @return bool
     */
    public function hasRouteArchitects(): bool
    {
        return !empty($this->routeArchitects);
    }

    /**
     * Gets the variables.
     *
     * @return string[]
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Converts route variables into a string.
     *
     * @return string
     */
    public function getVariablesString(): string
    {
        $segments = [];

        foreach ($this->variables as $key => $variable)
        {
            $segments[ $key ] = '';

            if ($this->isAssociativeVariables())
            {
                $segments[ $key ] .= $key . RouteArchitectConfig::URL_DELIMITER->getConfig();
            }

            $segments[ $key ] .= sprintf(RouteArchitectConfig::URL_VARIABLE_TEMPLATE->getConfig(), $variable);
        }

        return implode(RouteArchitectConfig::URL_DELIMITER->getConfig(), $segments);
    }

    /**
     * Sets the given variables.
     *
     * @param string[] $variables
     *
     * @return void
     */
    public function setVariables(array $variables): void
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
    public function addVariable(array | string $variables): static
    {
        $this->variables = array_merge($this->variables, (array) $variables);

        return $this;
    }

    /**
     * Determines whether there are any variables.
     *
     * @return bool
     */
    public function hasVariables(): bool
    {
        return !empty($this->variables);
    }

    /**
     * Determines whether the variables are in associative form.
     *
     * @return bool
     */
    public function isAssociativeVariables(): bool
    {
        return $this->hasVariables() && !array_is_list($this->variables);
    }

    /**
     * Gets sequences of names.
     *
     * @return RouteArchitectSequences
     */
    public function getNameSequences(): RouteArchitectSequences
    {
        return self::$nameSequences;
    }

    /**
     * Gets the sequence of the name.
     *
     * @return string|null
     */
    public function getNameSequence(): string | null
    {
        return self::$nameSequences->getSequence($this);
    }

    /**
     * Appends the sequence of the name.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return static
     */
    public function addNameSequence(RouteArchitect $routeArchitect): static
    {
        self::$nameSequences->addSequence($routeArchitect, $this);

        return $this;
    }

    /**
     * Determines whether the sequence of the name exists.
     *
     * @return bool
     */
    public function hasNameSequence(): bool
    {
        return self::$nameSequences->hasSequence($this);
    }

    /**
     * Gets sequences of views.
     *
     * @return RouteArchitectSequences
     */
    public function getViewSequences(): RouteArchitectSequences
    {
        return self::$viewSequences;
    }

    /**
     * Gets the sequence of the view.
     *
     * @return string|null
     */
    public function getViewSequence(): string | null
    {
        return self::$viewSequences->getSequence($this);
    }

    /**
     * Appends one or more sequence of the view.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return static
     */
    public function addViewSequence(RouteArchitect $routeArchitect): static
    {
        self::$viewSequences->addSequence($routeArchitect, $this);

        return $this;
    }

    /**
     * Determines whether the sequence of the view exists.
     *
     * @return bool
     */
    public function hasViewSequence(): bool
    {
        return self::$viewSequences->hasSequence($this);
    }

    /**
     * Implements the process of appending sequences by the given instance.
     *
     * @param RouteArchitect $routeArchitect
     *
     * @return static
     */
    public function addSequencesProcessing(RouteArchitect $routeArchitect): static
    {
        self::addNameSequence($routeArchitect);

        self::addViewSequence($routeArchitect);

        return $this;
    }

    /**
     * Gets the classname.
     *
     * @return string
     */
    public function getClassname(): string
    {
        return $this::class;
    }

    /**
     * Determines whether the current instance is a group.
     *
     * @return string
     */
    public function isGroup(): string
    {
        return $this->hasRouteArchitects();
    }
}
