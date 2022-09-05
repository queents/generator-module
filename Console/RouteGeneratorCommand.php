<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Modules\Generator\Services\ComponentGenerator\RouteGenerator;
use Symfony\Component\Console\Input\InputArgument;

class RouteGeneratorCommand extends Command
{
    use ModuleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make resource file inside VILT resource routes.';

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
        $actionName=$this->ask('Please input your route name? (ex: scan)');
        $requestType=$this->ask('Please input your route method type name? (ex: get | post | put | delete)');
        $methodName=$this->ask('Please input your route class method name? (ex: updateUser)');
        $pathRoute=$this->ask('Please input your route path? (ex: customer/scan)');
        $classResource=$this->ask('Please input your target resource class name? (ex: ScanResource)');
        $resourceName=$this->ask('Please input your current resource class name? (ex: AdminResource)');
        $moduleName=$this->ask('Please input your module name? (ex: Translations)');

        // create module if not exists
        $this->createModule($moduleName);


        $modelGenerator = new RouteGenerator(
            actionName:$actionName,
            moduleName:$moduleName,
            pathRoute:$pathRoute,
            classResource:$classResource,
            methodName:$methodName,
            requestType:$requestType,
            resourceName:$resourceName

     );
        $modelGenerator->generate();
        $this->info('The Route Has Been Generated :)');
    }
}
