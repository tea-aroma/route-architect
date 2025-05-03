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
     * The stub path.
     *
     * @var string
     */
    protected string $stubPath = __DIR__ . '/../Stubs/RouteArchitect.stub';

    /**
     * @param Command $command
     */
    function __construct(Command $command)
    {
        $this->command = $command;

        $this->setName($this->extractName($this->getArgument('name')));

        $this->setDirectory($this->extractPath($this->getArgument('name')));

        $this->setNamespace($this->extractPath($this->getArgument('name')));
    }

    /**
     * Extracts the only name from the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function extractName(string $name): string
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
    protected function extractPath(string $name): string
    {
        if (!preg_match('/\/|\\\\/', $name))
        {
            return '';
        }

        return preg_replace('/\W+\w*$/', '', $name);
    }

    /**
     * Handles the process of the directory.
     *
     * @return void
     */
    protected function directoryProcessing(): void
    {
        if (File::exists($this->getDirectory()))
        {
            return;
        }

        if (!File::makeDirectory($this->getDirectory(), 0755, true, true))
        {
            $this->state = RouteArchitectGeneratorStates::DIRECTORY_CREATE_ERROR;
        }
    }

    /**
     * Handles the process of the file.
     *
     * @return void
     */
    protected function fileProcessing(): void
    {
        if (File::exists($this->getFilename()))
        {
            $this->state = RouteArchitectGeneratorStates::FILE_EXIST;

            return;
        }

        if (!File::put($this->getFilename(), $this->getContent()))
        {
            $this->state = RouteArchitectGeneratorStates::FILE_CREATE_ERROR;
        }
    }

    /**
     * Gets the content of stub.
     *
     * @return string
     */
    protected function getContent(): string
    {
        $stub = new RouteArchitectStub($this, $this->getStubPath());

        return $stub->getContent();
    }

    /**
     * Generates the class.
     *
     * @return RouteArchitectGeneratorStates
     */
    public function generate(): RouteArchitectGeneratorStates
    {
        $this->directoryProcessing();

        if (!$this->isSuccess())
        {
            return $this->getState();
        }

        $this->fileProcessing();

        return $this->getState();
    }

    /**
     * Gets the filename.
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getName() . '.php';
    }

    /**
     * Gets the classname.
     *
     * @return string
     */
    public function getClassname(): string
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
    public function getArgument($key): array | bool | string | null
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
    public function getOption($key): array | bool | string | null
    {
        return $this->command->option($key);
    }

    /**
     * Gets the identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        $identifier = $this->getOption('identifier') ?? str_replace('RouteArchitect', '', $this->getName());

        return Str::slug($identifier);
    }

    /**
     * Gets the state.
     *
     * @return RouteArchitectGeneratorStates
     */
    public function getState(): RouteArchitectGeneratorStates
    {
        return $this->state;
    }

    /**
     * Gets the message of state.
     *
     * @return string
     */
    public function getStateMessage(): string
    {
        if (str_contains($this->state->value, '%s'))
        {
            return $this->state->format($this->getName());
        }

        return $this->state->value;
    }

    /**
     * Determines whether the current state is a success.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->state === RouteArchitectGeneratorStates::SUCCESS;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName(): string
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets the directory.
     *
     * @return string
     */
    public function getDirectory(): string
    {
        $directory = $this->directory;

        if (!empty($directory))
        {
            $directory = DIRECTORY_SEPARATOR . $directory;
        }

        return app_path(RouteArchitectConfig::DIRECTORY->getConfig()) . $directory;
    }

    /**
     * Sets the given directory.
     *
     * @param string $directory
     *
     * @return void
     */
    public function setDirectory(string $directory): void
    {
        $directory = preg_replace('/\\\\/', '/', $directory);

        $this->directory = $directory;
    }

    /**
     * Gets the namespace.
     *
     * @return string
     */
    public function getNamespace(): string
    {
        $namespace = $this->namespace;

        if (!empty($this->namespace))
        {
            $namespace = '\\' . $namespace;
        }

        return RouteArchitectConfig::NAMESPACE->getConfig() . $namespace;
    }

    /**
     * Sets the given namespace.
     *
     * @param string $namespace
     *
     * @return void
     */
    public function setNamespace(string $namespace): void
    {
        $namespace = preg_replace('/\//', '\\', $namespace);

        $this->namespace = $namespace;
    }

    /**
     * Gets the stub path.
     *
     * @return string
     */
    public function getStubPath(): string
    {
        return $this->stubPath;
    }
}