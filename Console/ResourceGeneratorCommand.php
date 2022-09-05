<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Services\ResourceGenerator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResourceGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make resource inside module with doctrine plugin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $moduleName=$this->argument('moduleName');
        $tableName=$this->argument('tableName');

        $resourceGenerator = new ResourceGenerator(tableName:$tableName,moduleName:$moduleName);
        $resourceGenerator->generate();
        $this->info(' Wow , The Resource Has Been Generated ;)');

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['tableName', InputArgument::REQUIRED, 'An example argument.'],
            ['moduleName', InputArgument::REQUIRED, 'An example argument.'],
            ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
