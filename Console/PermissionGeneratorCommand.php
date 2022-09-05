<?php

namespace Modules\Generator\Console;

use Illuminate\Console\Command;
use Modules\Generator\Services\PermissionGenerator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PermissionGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates permissions for specific table and assign it to role admin';

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
        $tableName=$this->argument('tableName');
        $permissionGenerator=new PermissionGenerator(tableName:$tableName);
        $permissionGenerator->generate();

        $this->info(' OH , The Permission Has Been Generated :(');

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
