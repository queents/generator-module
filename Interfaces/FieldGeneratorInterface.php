<?php


namespace Modules\Generator\Interfaces;

/**
 * this interface have base row implementations
 * */
interface FieldGeneratorInterface
{

    /**
     * @param string $component
     */
    public function generate(array $component):string;

    /**
     * return name space array for each child class
     */
    public function getNameSpace():array;

    /**
     * @param string $fieldName
     * @param string $fieldType
     *
     * init class name and label
     * @return FieldGeneratorInterface
     */
    public function make(string $fieldName , string $fieldType):self;

    /**
     * @param string $required
     * @param integer $length
     * @param string $type
     *
     * init validation for create and update methods
     * @return FieldGeneratorInterface
     */
    public function validation(string $required, int $length, string $type):self;

    /**
     * @param bool $unique
     * check if uniq append class
     * @return FieldGeneratorInterface
     */
    public function unique(bool $unique):self;

    /**
     * append over function
     */
    public function over():self;

    /**
     * append list function with false
     * @return FieldGeneratorInterface
     */
    public function list():self;

    /**
     * append view function with false
     * @return FieldGeneratorInterface
     */
    public function view():self;


    /**
     * @param string $type
     * @return FieldGeneratorInterface
     */
    public function type(string $type):self;

    /**
     * @param mixed $default
     * @return FieldGeneratorInterface
     */
    public function default(mixed $default):self;


    /**
     * @param string $options
     * @return FieldGeneratorInterface
     */
    public function options(string $options):self;
}
