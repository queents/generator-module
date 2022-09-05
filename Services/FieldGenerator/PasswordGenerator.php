<?php


namespace Modules\Generator\Services\FieldGenerator;


use Modules\Generator\Interfaces\FieldGeneratorAbstract;

class PasswordGenerator extends FieldGeneratorAbstract
{

    private string $class="Text";

    protected array $nameSpace=['string'=>"use Modules\Base\Services\Rows\Text;
    "];

    public function validation( string $required="required",int $length=255,string $type="string"):self{
        $this->output .='
                        ->validation([
                            "create" => "'.$required.'|'.$type.'|max:'.$length.'|confirmed",
                            "update" => "'.$required.'|'.$type.'|max:'.$length.'|confirmed"
                        ])';
        return $this;
    }




    public function generate( array $component):string{

        $this->make($component['name'],$this->class)
            ->validation($component['required'],$component['maxLength'])
            ->type('password')
            ->default($component['default'])
            ->unique($component['unique'])->view()->list();

        $this->output .=',';

        $this->make('password_confirmation',$this->class)->type('password')->over()->view()->list();

        $temp=$this->output.',';
        $this->output='';
        return $temp;
    }


}
