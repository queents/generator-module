<?php

namespace Modules\Generator\Services\FieldGenerator;

use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class PhoneGenerator extends FieldGeneratorAbstract
{
    protected array $nameSpace=['tel'=>"use Modules\Base\Services\Rows\Tel;
    "];

    public function generate( array $component):string{

        $this->make($component['name'],'Tel')
            ->validation($component['required'],$component['maxLength'])
            ->default($component['default'])
            ->unique($component['unique']);

        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }
}
