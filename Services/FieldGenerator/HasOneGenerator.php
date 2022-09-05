<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class HasOneGenerator extends FieldGeneratorAbstract
{
    private string $class="HasOne";

    protected array $nameSpace=['hasOne'=>"use Modules\Base\Services\Rows\HasOne;
    "];
    public string $output='';

    //move it to interface and abstract
    public function model( $model ){
            $this->output .='
                        ->model('.$model.'::class)';

        return $this;
    }
    public function relation( $fieldName ){
        $name=explode('_id',$fieldName);
        $this->output .='
                        ->relation("'.$name[0].'")';

        return $this;
    }
    public function generate(array $component):string{
        $this->make($component['name'],$this->class)->validation($component['required'],$component['maxLength'],'array')
            ->unique($component['unique'])
            ->model($component['relation']['model'])
            ->default($component['default'])
            ->relation($component['name']);
        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }



}
