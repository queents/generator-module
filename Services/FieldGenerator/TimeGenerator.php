<?php

namespace Modules\Generator\Services\FieldGenerator;

use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class TimeGenerator extends FieldGeneratorAbstract
{
    private string $class="Time";

    protected array $nameSpace=['time'=>"use Modules\Base\Services\Rows\Time;
    "];

    public function validation( string $required="required",int $length=255,string $type="string"):self{
        $this->output .='
                        ->validation([
                            "create" => "'.$required.'|'.$type.'",
                            "update" => "'.$required.'|'.$type.'"
                        ])';
        return $this;
    }

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
