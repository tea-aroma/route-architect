<?php

namespace TeaAroma\RouteArchitect\Classes;


use Illuminate\Support\Collection;


/**
 * Implements logical management for work with the middlewares.
 */
class RouteArchitectMiddlewares
{
    /**
     * The middlewares.
     *
     * @var Collection<class-string>
     */
    protected Collection $middlewares;

    /**
     * @param class-string[] $middlewares
     */
    public function __construct(array $middlewares = [])
    {
        $this->middlewares = new Collection($middlewares);
    }

    /**
     * Gets the middlewares.
     *
     * @return Collection<class-string>
     */
    public function get_middlewares(): Collection
    {
        return $this->middlewares;
    }

    /**
     * Sets the given middlewares.
     *
     * @param Collection<class-string> $middlewares
     *
     * @return void
     */
    public function set_middlewares(Collection $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Appends one or more middleware to the existing list.
     *
     * @param class-string[]|class-string $middleware
     *
     * @return void
     */
    public function add_middlewares(array | string $middleware): void
    {
        $this->middlewares->merge((array) $middleware);
    }

    /**
     * Determines whether the middleware by the given name exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has_middleware(string $name): bool
    {
        return $this->middlewares->contains($name);
    }

    /**
     * Determines whether there are not any middlewares.
     *
     * @return bool
     */
    public function is_empty(): bool
    {
        return $this->middlewares->isEmpty();
    }

    /**
     * Converts the collection of middlewares to array.
     *
     * @return array<class-string>
     */
    public function to_array(): array
    {
        return $this->middlewares->toArray();
    }
}
