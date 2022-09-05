<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Modules\Generator\Services\ComponentGenerator\ModalGenerator;
use Symfony\Component\Console\Input\InputArgument;

class ModalGeneratorCommand extends Command
{
    use ModuleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:modal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make resource file inside VILT resource modals.';

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
        $actionName=$this->ask('Please input your modal name? (ex: Import)');
        $resourceName=$this->ask('Please input your resource class name? (ex: ScanResource)');
        $moduleName=$this->ask('Please input your module name? (ex: Translations)');

        // create module if not exists
        $this->createModule($moduleName);


        $modelGenerator = new ModalGenerator(actionName:$actionName,moduleName:$moduleName,resourceName:$resourceName);
        $modelGenerator->generate();
        $this->info('The Modal Has Been Generated :)');
    }
}
