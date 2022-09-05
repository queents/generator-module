<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class ColorGenerator extends FieldGeneratorAbstract
{

    private string $class="Color";
    protected array $nameSpace=['color'=>"use Modules\Base\Services\Rows\Color;
    "];

    public function generate( array $component):string{

        $this->make($component['name'],$this->class)
            ->validation($component['required'],$component['maxLength'])
            ->default($component['default'])
            ->unique($component['unique']);

        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }




}
