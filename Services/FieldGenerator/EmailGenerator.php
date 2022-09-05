<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class EmailGenerator extends FieldGeneratorAbstract
{

    private string $class="Email";

    protected array $nameSpace=['email'=>"use Modules\Base\Services\Rows\Email;
    "];

    public function generate( array $component):string{

        $this->make($component['name'],$this->class)
            ->validation($component['required'],$component['maxLength'],'email')
            ->default($component['default'])
            ->unique($component['unique']);
        $temp=$this->output.',';
        $this->output='';
        return $temp;    }


}
