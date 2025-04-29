<?php

namespace TeaAroma\RouteArchitect\AutoScanner;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Enums\RouteArchitectErrors;


/**
 * Collects, scans and registers 'RouteArchitect' entries.
 */
class RouteArchitectAutoScanner
{
    /**
     * The directory path.
     *
     * @var string
     */
    readonly public string $directory;

    /**
     * The entries.
     *
     * @var RouteArchitectScannedEntries
     */
    protected RouteArchitectScannedEntries $entries;

    /**
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        $this->directory = $directory;

        $this->entries = new RouteArchitectScannedEntries();
    }

    /**
     * Initializes scanning and registering.
     *
     * @return void
     */
    public function initialization(): void
    {
        $this->scan();

        $this->register();
    }

    /**
     * Handles the process of the nested 'RouteArchitect' classes by the given entry.
     *
     * @param RouteArchitectScannedEntry $entry
     *
     * @return void
     */
    protected function routeArchitectProcessing(RouteArchitectScannedEntry $entry): void
    {
        foreach ($entry->routeArchitect->getRouteArchitects() as $routeArchitect)
        {
            if ($this->entries->hasEntry($routeArchitect))
            {
                $this->entries->getEntry($routeArchitect)->toPass();

                continue;
            }

            $nestedEntry = new RouteArchitectScannedEntry($routeArchitect);

            $nestedEntry->toPass();

            $this->entries->addEntry($routeArchitect, $nestedEntry);
        }
    }

    /**
     * Scans all files.
     *
     * @return void
     */
    protected function scan(): void
    {
        if (empty($this->getFiles()))
        {
            Log::error(RouteArchitectErrors::NO_PHP_FILES->format($this->directory));
        }

        foreach ($this->getFiles() as $file)
        {
            $namespace = $this->getNamespace($file);

            if (!class_exists($namespace))
            {
                throw new \LogicException(RouteArchitectErrors::UNDEFINED_NAMESPACE->format($namespace));
            }

            $entry = new RouteArchitectScannedEntry($namespace);

            $this->routeArchitectProcessing($entry);

            if ($this->entries->hasEntry($namespace))
            {
                continue;
            }

            $this->entries->addEntry($namespace, $entry);
        }
    }

    /**
     * Registers all entries.
     *
     * @return void
     */
    protected function register(): void
    {
        foreach ($this->entries->getEntries() as $entry)
        {
            if ($entry->isPass())
            {
                continue;
            }

            $entry->register();
        }
    }

    /**
     * Gets all PHP files.
     *
     * @return \SplFileInfo[]
     */
    public function getFiles(): array
    {
        return array_filter(File::allFiles($this->directory), $this->isPHPFile( ... ));
    }

    /**
     * Determines whether the extension of the given file is PHP.
     *
     * @param \SplFileInfo $file
     *
     * @return bool
     */
    protected function isPHPFile(\SplFileInfo $file): bool
    {
        return $file->getExtension() === 'php';
    }

    /**
     * Gets the namespace of class by the given file.
     *
     * @param \SplFileInfo $file
     *
     * @return class-string<RouteArchitect>
     */
    protected function getNamespace(\SplFileInfo $file): string
    {
        $file = 'App' . substr($file->getRealPath(), strlen(app_path()));

        return str_replace([ '/', '.php' ], [ '\\', '' ], $file);
    }

    /**
     * Gets the entries.
     *
     * @return RouteArchitectScannedEntries
     */
    public function getEntries(): RouteArchitectScannedEntries
    {
        return $this->entries;
    }
}
