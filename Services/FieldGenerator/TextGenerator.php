<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class TextGenerator extends FieldGeneratorAbstract
{

    private string $class="Text";

    protected array $nameSpace=['string'=>"use Modules\Base\Services\Rows\Text;
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
