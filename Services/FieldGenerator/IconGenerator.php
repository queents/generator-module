<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class IconGenerator extends FieldGeneratorAbstract
{
    private string $class="Icon";

    protected array $nameSpace=['icon'=>"use Modules\Base\Services\Rows\Icon;
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
