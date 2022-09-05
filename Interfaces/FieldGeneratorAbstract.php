<?php


namespace Modules\Generator\Interfaces;

use Illuminate\Support\Str;

/**
 * abstract interface implementation
 *
 * @var  $output
 * @var  $nameSpace
 * output var is the string contain all functions appended to it buy generate function
 * namespace each child has namespace
 */
abstract class FieldGeneratorAbstract implements FieldGeneratorInterface
{

    public string $output='';
    protected array $nameSpace=[];

    /**
     * @param array $component
     *
     * every child should implement this function
     * this function contain the row function structure
     * @return string
     */
    abstract public function generate(array $component):string;


    /**
     * @return array
     *
     * return the key and value namespace
     */
    public function getNameSpace():array{
        return $this->nameSpace;
    }


    /**
     * @param string $fieldName
     * @param string $fieldType
     * @return $this|void
     * init class name and label
     */
    public function make(string $fieldName , string $fieldType):self{

        $filedNameSp = Str::replace(' ', '_',$fieldName);
        $this->output .="

                    {$fieldType}::make('{$filedNameSp}')
                        ->label(__('".$fieldName."'))";
        return $this;
    }

    /**
     * @param string $required
     * @param integer $length
     * @param string $type
     * @return $this
     */
    public function validation(string $required="required", int $length=255, string $type="string"):self{
        $this->output .='
                        ->validation([
                            "create" => "'.$required.'|'.$type.'|max:'.$length.'",
                            "update" => "'.$required.'|'.$type.'|max:'.$length.'"
                        ])';
        return $this;
    }

    /**
     * @param bool $unique
     * @return $this|FieldGeneratorInterface
     */
    public function unique( bool $unique=true ):self{
        if ($unique)
            $this->output .='
                        ->unique()';

        return $this;
    }

    /**
     * @param bool $unique
     * @return $this|FieldGeneratorInterface
     */
    public function default(mixed $default):self{
        if ($default)
            $this->output .='
                        ->default("'.$default.'")';

        return $this;
    }

    /**
     * @return $this
     */
    public function over():self{
        $this->output .='
                        ->over()';

        return $this;
    }

    /**
     * @return $this
     */
    public function list():self {
        $this->output .='
                        ->list(false)';

        return $this;
    }

    /**
     * @return $this
     */
    public function view():self{
        $this->output .='
                        ->view(false)';

        return $this;
    }
    /**
     * @return $this
     */
    public function create():self{
        $this->output .='
                        ->create(false)';

        return $this;
    }

    /**
     * @return $this
     */
    public function edit():self{
        $this->output .='
                        ->edit(false)';

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type):self{
        $this->output .='
                        ->type("'.$type.'")';

        return $this;
    }

    /**
     * @param string $options
     * @return $this
     */
    public function options(string $options):self{
        $this->output .='
                        ->options('.$options.')';

        return $this;
    }





}
