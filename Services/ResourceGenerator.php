<?php


namespace Modules\Generator\Services;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Generator\Interfaces\GeneratorInterface;
use Modules\Generator\Services\Helpers\CanManipulateFiles;
use Modules\Generator\Services\TraitsGenerator\ComponentsGenerator;
use Modules\Generator\Services\TraitsGenerator\TranslationsGenerator;

/**
 * Class ResourceGenerator
 * @package Modules\Generator\Services
 *
 */
class ResourceGenerator implements GeneratorInterface
{

    use CanManipulateFiles;

    private Connection $connection;
    private ?string $modelName;
    private array $types = [
         "email",
         "password",
         "tel",
         "color",
         "icon",
         "name",
    ];

    /**
     * ResourceGenerator constructor.
     * @param $tableName
     * @param $moduleName
     *
     * this constructor create DB connection object
     * get doctrine DriverManager and make connection
     * convert table name (table name with s and _) to model camelCase
     */
    public function __construct(
         public string $tableName,
        public string $moduleName
    )
    {
        $connectionParams = [
            'dbname' => config('database.connections.mysql.database'),
            'user' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
            'host' => config('database.connections.mysql.host'),
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->generateModelName();
    }

    public function generateModelName()
    {
        $this->modelName = ucfirst(Str::camel(Str::singular($this->tableName)));
    }

    public function generate()
    {
        $replacements =$this->generateFields();
        $this->render($replacements, module_path($this->moduleName) .  '/Vilt/Resources/' . $this->modelName . 'Resource.php');

        $traitGenerator=new TranslationsGenerator($replacements['headerTranslationName'],
            $replacements['fieldsTranslationName'],$replacements['model'],$this->moduleName);
        $traitGenerator->generate();

        $componentsGenerator=new ComponentsGenerator($replacements['model'],$this->moduleName);
        $componentsGenerator->generate();

    }

    public function getFields() {
    $components = [];

    $tableSchema = $this->connection->getSchemaManager();
    $columns = $tableSchema->listTableDetails($this->tableName);

    $types=[];
    foreach ($columns->getColumns() as $column) {

        if (Str::of($column->getName())->endsWith([
            '_at',
            '_token',
        ])) {
            continue;
        }

        $componentData = [];

        $componentData['name'] =str_replace('_', ' ', $column->getName());
        $componentData['type']=$column->getType()->getName();
        $componentData['default']=$column->getDefault();


        $unqieName = $this->tableName . '_' . $column->getName() . '_unique';
        if ($columns->hasIndex($unqieName)) {
            $componentData['unique'] = true;
        } else {
            $componentData['unique'] = false;
        }

        if ($componentData['type'] === "string") {

            if (Str::of($column->getName())->contains(['email'])) {
                $componentData['type'] = "email";
            }

            if (Str::of($column->getName())->contains(['password'])) {
                $componentData['type'] = "password";
            }

            if (Str::of($column->getName())->contains(['phone', 'tel'])) {
                $componentData['type'] = "tel";
            }

            if (Str::of($column->getName())->contains(['color'])) {
                $componentData['type'] = "color";
            }

            if (Str::of($column->getName())->contains(['icon'])) {
                $componentData['type'] = "icon";
            }
        }
        if ($componentData['type'] === "integer" || $componentData['type'] === "float" || $componentData['type'] === "double") {
            $componentData['type'] = "int";
        }

        if (Str::of($column->getName())->endsWith([
            '_id'
        ]))
        {

            if ($columns->hasForeignKey($this->tableName . '_' . $column->getName() . '_foreign')) {
                $getKey = $columns->getForeignKey($this->tableName . '_' . $column->getName() . '_foreign');
                $model = "\\Modules\\" . $this->moduleName . "\\Entities\\" . Str::studly(Str::singular($getKey->getForeignTableName()));
                $componentData['relation'] = [
                    "table" => $getKey->getForeignTableName(),
                    "field" => $getKey->getForeignColumns()[0],
                    "model" => $model
                ];
                $componentData['type'] = 'relation';
            }
        }

        if ($column->getNotnull()) {
            $componentData['required'] = 'required';
        } else {
            $componentData['required'] = 'nullable';
        }


        if ($length = $column->getLength()) {
            if ($length > 255) {
                $componentData['type'] = 'textarea';
            }
            $componentData['maxLength'] = $length;
        } else {
            $componentData['maxLength'] = false;
        }

       if($column->getLength() < 1 && $componentData['type'] === 'text'){
            $componentData['type'] = 'longText';
        }

        $components[] = $componentData;
    }

    return $components;


    }

    public function generateFields(){
        $components= $this->getFields();

        $fieldFactory= new FieldFactory();
        $output='';
        $nameSpaces=[];
        foreach ($components as $component){
            $fieldClass=$fieldFactory->getField($component['type']);
            if ($fieldClass){
                $output .=$fieldClass->generate($component);
                $nameSpaces=array_merge($nameSpaces,$fieldClass->getNameSpace());

            }
        }
        $replacements=[
            "fields"=>$output,
            "nameSpaces"=>implode($nameSpaces),
            "model"=>$this->modelName,
            "module"=>$this->moduleName,
            "headerTranslationName"=>ucwords(implode(' ',preg_split('/(?=[A-Z])/', $this->modelName.'s'))),
            "fieldsTranslationName"=>ucwords(implode(' ',preg_split('/(?=[A-Z])/', $this->modelName)))
        ];

        return $replacements;
        }



    public function render($replacements, $path)
    {

        try{
            File::makeDirectory(module_path($this->moduleName) .  '/Vilt');
            File::makeDirectory(module_path($this->moduleName) .  '/Vilt/Resources');
        }catch (\Exception $e){}

        if (File::exists($path))
             File::delete($path);

         $this->copyStubToApp('Resource',$path,$replacements);

    }

}
