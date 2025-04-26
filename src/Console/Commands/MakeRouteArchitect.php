<?php

namespace TeaAroma\RouteArchitect\Console\Commands;


use Illuminate\Console\Command;
use TeaAroma\RouteArchitect\Generators\RouteArchitectGenerator;


/**
 * Console command for generating a new 'RouteArchitect' class.
 */
class MakeRouteArchitect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:route-architect {name} {--identifier=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new RouteArchitect class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $generator = new RouteArchitectGenerator($this);

        $generator->generate();

        if (!$generator->isSuccess())
        {
            $this->error($generator->getStateMessage());

            return;
        }

        $this->info($generator->getStateMessage());
    }
}
