<?php

namespace TeaAroma\RouteArchitect\Generators;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;
use TeaAroma\RouteArchitect\Enums\RouteArchitectGeneratorStates;


/**
 * Generates a new 'RouteArchitect' class.
 */
class RouteArchitectGenerator
{
    /**
     * The state.
     *
     * @var RouteArchitectGeneratorStates
     */
    protected RouteArchitectGeneratorStates $state = RouteArchitectGeneratorStates::SUCCESS;

    /**
     * The instance of 'Command'.
     *
     * @var Command
     */
    protected Command $command;

    /**
     * The name.
     *
     * @var string
     */
    protected string $name;

    /**
     * The directory.
     *
     * @var string
     */
    protected string $directory;

    /**
     * The namespace.
     *
     * @var string
     */
    protected string $namespace;

    /**
     * The path of stub.
     *
     * @var string
     */
    protected string $stub_path = 'Stubs/RouteArchitect.stub';

    /**
     * @param Command $command
     */
    function __construct(Command $command)
    {
        $this->command = $command;

        $this->set_name($this->extract_name($this->get_argument('name')));

        $this->set_directory($this->extract_path($this->get_argument('name')));

        $this->set_namespace($this->extract_path($this->get_argument('name')));
    }

    /**
     * Extracts the only name from the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function extract_name(string $name): string
    {
        return preg_replace('/^.*\W+/', '', $name);
    }

    /**
     * Extracts the only path from the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function extract_path(string $name): string
    {
        return preg_replace('/\W+\w*$/', '', $name);
    }

    /**
     * Handles the process of the directory.
     *
     * @return void
     */
    protected function directory_processing(): void
    {
        if (File::exists($this->get_directory()))
        {
            return;
        }

        if (!File::makeDirectory($this->get_directory(), 0755, true, true))
        {
            $this->state = RouteArchitectGeneratorStates::DIRECTORY_CREATE_ERROR;
        }
    }

    /**
     * Handles the process of the file.
     *
     * @return void
     */
    protected function file_processing(): void
    {
        if (File::exists($this->get_filename()))
        {
            $this->state = RouteArchitectGeneratorStates::FILE_EXIST;

            return;
        }

        if (!File::put($this->get_filename(), $this->get_content()))
        {
            $this->state = RouteArchitectGeneratorStates::FILE_CREATE_ERROR;
        }
    }

    /**
     * Gets the content of stub.
     *
     * @return string
     */
    protected function get_content(): string
    {
        $stub = new RouteArchitectStub($this, $this->get_stub_path());

        return $stub->get_content();
    }

    /**
     * Generates the class.
     *
     * @return RouteArchitectGeneratorStates
     */
    public function generate(): RouteArchitectGeneratorStates
    {
        $this->directory_processing();

        if (!$this->is_success())
        {
            return $this->get_state();
        }

        $this->file_processing();

        if (!$this->is_success())
        {
            return $this->get_state();
        }

        $this->state = RouteArchitectGeneratorStates::SUCCESS;

        return $this->get_state();
    }

    /**
     * Gets the filename.
     *
     * @return string
     */
    public function get_filename(): string
    {
        return $this->get_directory() . DIRECTORY_SEPARATOR . $this->get_name() . '.php';
    }

    /**
     * Gets the classname.
     *
     * @return string
     */
    public function get_classname(): string
    {
        return Str::studly($this->name);
    }

    /**
     * Gets the argument by the given key.
     *
     * @param $key
     *
     * @return array|bool|string|null
     */
    public function get_argument($key): array | bool | string | null
    {
        return $this->command->argument($key);
    }

    /**
     * Gets the option by the given key.
     *
     * @param $key
     *
     * @return array|bool|string|null
     */
    public function get_option($key): array | bool | string | null
    {
        return $this->command->option($key);
    }

    /**
     * Gets the identifier.
     *
     * @return string
     */
    public function get_identifier(): string
    {
        $identifier = $this->get_option('identifier') ?? str_replace('RouteArchitect', '', $this->get_name());

        return Str::slug($identifier);
    }

    /**
     * Gets the state.
     *
     * @return RouteArchitectGeneratorStates
     */
    public function get_state(): RouteArchitectGeneratorStates
    {
        return $this->state;
    }

    /**
     * Gets the message of state.
     *
     * @return string
     */
    public function get_state_message(): string
    {
        if (str_contains($this->state->value, '%s'))
        {
            return $this->state->format($this->get_name());
        }

        return $this->state->value;
    }

    /**
     * Determines whether the current state is a success.
     *
     * @return bool
     */
    public function is_success(): bool
    {
        return $this->state === RouteArchitectGeneratorStates::SUCCESS;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function get_name(): string
    {
        return $this->name;
    }

    /**
     * Sets the given name.
     *
     * @param string $name
     *
     * @return void
     */
    public function set_name(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets the directory.
     *
     * @return string
     */
    public function get_directory(): string
    {
        return app_path(RouteArchitectConfig::DIRECTORY->get_config()) . DIRECTORY_SEPARATOR . $this->directory;
    }

    /**
     * Sets the given directory.
     *
     * @param string $directory
     *
     * @return void
     */
    public function set_directory(string $directory): void
    {
        $directory = preg_replace('/\\\\/', '/', $directory);

        $this->directory = $directory;
    }

    /**
     * Gets the namespace.
     *
     * @return string
     */
    public function get_namespace(): string
    {
        return RouteArchitectConfig::NAMESPACE->get_config() . '\\' . $this->namespace;
    }

    /**
     * Sets the given namespace.
     *
     * @param string $namespace
     *
     * @return void
     */
    public function set_namespace(string $namespace): void
    {
        $namespace = preg_replace('/\//', '\\', $namespace);

        $this->namespace = $namespace;
    }

    /**
     * Gets the path of stub.
     *
     * @return string
     */
    public function get_stub_path(): string
    {
        return app_path($this->stub_path);
    }
}