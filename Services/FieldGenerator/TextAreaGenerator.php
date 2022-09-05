<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class TextAreaGenerator extends FieldGeneratorAbstract
{
    private string $class="Textarea";

    protected array $nameSpace=['textarea'=>"use Modules\Base\Services\Rows\Textarea;
    "];
    public string $output='';



    public function generate(array $component):string{
        $this->make($component['name'],$this->class)
            ->validation($component['required'],$component['maxLength'])
            ->default($component['default'])
            ->unique($component['unique']);
        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }


}
