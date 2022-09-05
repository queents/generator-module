<?php


namespace Modules\Generator\Services;


use Modules\Generator\Interfaces\FieldGeneratorInterface;
use Modules\Generator\Services\FieldGenerator\ColorGenerator;
use Modules\Generator\Services\FieldGenerator\DateGenerator;
use Modules\Generator\Services\FieldGenerator\DateTimeGenerator;
use Modules\Generator\Services\FieldGenerator\EmailGenerator;
use Modules\Generator\Services\FieldGenerator\HasOneGenerator;
use Modules\Generator\Services\FieldGenerator\IconGenerator;
use Modules\Generator\Services\FieldGenerator\IdGenerator;
use Modules\Generator\Services\FieldGenerator\JSONGenerator;
use Modules\Generator\Services\FieldGenerator\NumberGenerator;
use Modules\Generator\Services\FieldGenerator\PasswordGenerator;
use Modules\Generator\Services\FieldGenerator\PhoneGenerator;
use Modules\Generator\Services\FieldGenerator\RichTextGenerator;
use Modules\Generator\Services\FieldGenerator\TextAreaGenerator;
use Modules\Generator\Services\FieldGenerator\TextGenerator;
use Modules\Generator\Services\FieldGenerator\TimeGenerator;
use Modules\Generator\Services\FieldGenerator\ToggleGenerator;

/**
 * Class FieldFactory
 * @package Modules\Generator\Services
 */
class FieldFactory
{

    public array $fields;

    /**
     * FieldFactory constructor.
     * you can add the key that refer to filed class
     */
    public function __construct(){
        $this->fields = [
            "string" => new TextGenerator(),
            "email" => new EmailGenerator(),
            "tel" => new PhoneGenerator(),
            "boolean" => new ToggleGenerator(),
            "time" => new TimeGenerator(),
            "textarea" => new TextAreaGenerator(),
            "longText" => new RichTextGenerator(),
            "bigint" => new IdGenerator(),
            "relation" => new HasOneGenerator(),
            "color" => new ColorGenerator(),
//            "icon" => new IconGenerator(),
            "date" => new DateGenerator(),
            "datetime" => new DateTimeGenerator(),
            "password" => new PasswordGenerator(),
            "int" => new NumberGenerator(),
            "json" => new JSONGenerator(),
            ];
    }


    /**
     * @param string $fieldType
     * @return int|mixed
     */
    //make ir return interface and add defualt class
    //:FieldGeneratorInterface
    public function getField(string $fieldType):FieldGeneratorInterface{

        if (array_key_exists($fieldType, $this->fields))
            return $this->fields[$fieldType];

        return $this->fields['string'];
    }
}
