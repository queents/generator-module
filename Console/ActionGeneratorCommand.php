<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Modules\Generator\Services\ComponentGenerator\ActionGenerator;
use Symfony\Component\Console\Input\InputArgument;

class ActionGeneratorCommand extends Command
{

    use ModuleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make action file inside VILT resource actions.';

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
        $actionName=$this->ask('Please input your action name? (ex: Scan)');
        $resourceName=$this->ask('Please input your resource class name? (ex: ScanResource)');
        $moduleName=$this->ask('Please input your module name? (ex: Translations)');

        // create module if not exists
        $this->createModule($moduleName);


        $modelGenerator = new ActionGenerator(actionName:$actionName,moduleName:$moduleName,resourceName:$resourceName);
        $modelGenerator->generate();
        $this->info('The Action Has Been Generated :)');
    }
}
