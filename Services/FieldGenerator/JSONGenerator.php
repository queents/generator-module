<?php

namespace Modules\Generator\Services\FieldGenerator;

use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class JSONGenerator extends FieldGeneratorAbstract
{
    private string $class="Schema";
    protected array $nameSpace=['json'=>"use Modules\Base\Services\Rows\Schema;
    "];
    public string $output='';

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
            ->validation($component['required'],$component['maxLength'], 'array')
            ->options("[]")
            ->default($component['default'])
            ->unique($component['unique']);
        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }

}
