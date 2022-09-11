<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Modules\Generator\Services\ComponentGenerator\ViewsGenerator;
use Modules\Generator\Services\ComponentGenerator\WidgetGenerator;
use Symfony\Component\Console\Input\InputArgument;

class ViewsGeneratorCommand extends Command
{
    use ModuleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make view file inside Resources/views folder';

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
        $actionName=$this->ask('Please input your table name? (ex: authors)');
        $moduleName=$this->ask('Please input your module name? (ex: Blog)');

        // create module if not exists
        $this->createModule($moduleName);


        $modelGenerator = new ViewsGenerator(actionName:$actionName,moduleName:$moduleName);
        $modelGenerator->generate();
        $this->info('The Views Has Been Generated :)');
    }


}
