<?php

namespace TeaAroma\RouteArchitect\Generators;


use Illuminate\Support\Facades\File;


/**
 * Handles the process for stub file.
 */
class RouteArchitectStub
{
    /**
     * The instance of 'RouteArchitectGenerator'.
     *
     * @var RouteArchitectGenerator
     */
    protected RouteArchitectGenerator $generator;

    /**
     * The stub path.
     *
     * @var string
     */
    protected string $path;

    /**
     * @param RouteArchitectGenerator $generator
     * @param string                  $path
     */
    public function __construct(RouteArchitectGenerator $generator, string $path)
    {
        $this->generator = $generator;

        $this->path = $path;
    }

    /**
     * Gets the content of stub file.
     *
     * @return string
     */
    protected function getStubContent(): string
    {
        return File::get($this->getPath());
    }

    /**
     * Gets the content.
     *
     * @return string
     */
    public function getContent(): string
    {
        return strtr($this->getStubContent(), $this->getReplacements());
    }

    /**
     * Gets variables and their replacements for the stub.
     *
     * @return array
     */
    protected function getReplacements(): array
    {
        return [
            '{{classname}}' => $this->generator->getClassname(),
            '{{namespace}}' => $this->generator->getNamespace(),
            '{{identifier}}' => $this->generator->getIdentifier()
        ];
    }

    /**
     * Gets the stub path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
