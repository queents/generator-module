<?php


namespace Modules\Generator\Services\FieldGenerator;


use Illuminate\Support\Str;
use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class IdGenerator extends FieldGeneratorAbstract
{

    private string $class="Text";

    protected array $nameSpace=['string'=>"use Modules\Base\Services\Rows\Text;
    "];

    public function generate(array $component):string{
        $this->make($component['name'],$this->class)
            ->default($component['default'])
            ->unique($component['unique'])
            ->create()
            ->edit();
        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }

}
