<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Generator\Services\ModelGenerator;

class ModelGeneratorCommand extends Command
{
    use ModuleHandler;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make model inside module with krlove plugin';

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
        $moduleName=$this->argument('moduleName');
        $tableName=$this->argument('tableName');

        // create module if not exists
        $this->createModule($moduleName);


        $modelGenerator = new ModelGenerator(tableName:$tableName,moduleName:$moduleName);
        $modelGenerator->generate();
        $this->info(' Yaaay , The Model Has Been Generated :)');

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

}
