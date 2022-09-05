<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Console\Helpers\ModuleHandler;
use Symfony\Component\Console\Input\InputArgument;

class GeneratorCommand extends Command
{

    use ModuleHandler;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates crud files';

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

        $tableName= $this->ask('Please input your database table name?');
        $moduleName= $this->ask('Please input module name?');

        //call bake model
        $this->call('vilt:model',[
            'tableName' =>$tableName,
            "moduleName" =>$moduleName
        ]);

        //call bake permission
        $this->call('vilt:permission',[
            'tableName' =>$tableName,
        ]);

        //call bake resource
        $this->call('vilt:resource',[
            'tableName' =>$tableName,
            "moduleName" =>$moduleName
        ]);
    }
}
