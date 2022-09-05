<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Modules\Generator\Services\ComponentGenerator\PageGenerator;
use Modules\Generator\Services\ComponentGenerator\PageVueGenerator;
use Symfony\Component\Console\Input\InputArgument;

class PageGeneratorCommand extends Command
{
    use ModuleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make resource file inside vilt resource pages.';

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
        $actionName=$this->ask('Please input your page name?');
        $moduleName=$this->ask('Please input your module name?');


        // create module if not exists
        $this->createModule($moduleName);


        $modelGenerator = new PageGenerator(actionName:$actionName,moduleName:$moduleName);
        $modelGenerator->generate();
        $this->info('The Page Has Been Generated :)');

        $modelGenerator = new PageVueGenerator(actionName:$actionName,moduleName:$moduleName);
        $modelGenerator->generate();
        $this->info('The Vue Page Has Been Generated :)');
    }
}
