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
     * The path of stub.
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
     * Gets the content of stub.
     *
     * @return string
     */
    protected function get_stub_content(): string
    {
        return File::get($this->get_path());
    }

    /**
     * Gets the content.
     *
     * @return string
     */
    public function get_content(): string
    {
        return strtr($this->get_stub_content(), $this->get_replacements());
    }

    /**
     * Gets variables and their replacements for the stub.
     *
     * @return array
     */
    protected function get_replacements(): array
    {
        return [
            '{{classname}}' => $this->generator->get_classname(),
            '{{namespace}}' => $this->generator->get_namespace(),
            '{{identifier}}' => $this->generator->get_identifier()
        ];
    }

    /**
     * Gets the path.
     *
     * @return string
     */
    public function get_path(): string
    {
        return $this->path;
    }
}
