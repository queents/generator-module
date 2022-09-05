<?php


namespace Modules\Generator\Services\ComponentGenerator;


use Illuminate\Support\Str;
use Modules\Generator\Interfaces\GeneratorInterface;
use Modules\Generator\Services\Helpers\CanManipulateFiles;

class ActionGenerator implements GeneratorInterface
{
    use CanManipulateFiles;


    private string $actionLabel;
    private string $modelName;
    private array $folderDirectory;
    private string $stubPath;
    private string $targetPath;
    /**
     * ModelGenerator constructor.
     * @param string $tableName
     * @param string $moduleName
     */
    public function __construct(
        public string $actionName,
        public string $moduleName,
        public string $resourceName
    )
    {
        $this->generateModelName();
    }

    public function generateModelName()
    {
        $this->modelName = ucfirst(Str::camel($this->actionName));
        $this->actionLabel =trim(ucwords(implode(' ',preg_split('/(?=[A-Z])/', $this->modelName))));
        $this->folderDirectory =["/Vilt","/Resources","/".$this->resourceName,"/Actions"];
        $this->stubPath ="Resources/ModuleResource/Actions/ModuleAction";
        $this->targetPath =module_path($this->moduleName).  '/Vilt/Resources/' . $this->resourceName . '/Actions/'.$this->modelName.'Action.php';
    }

    public function generate()
    {
        $this->checkForCollision();
        $this->copyStubToApp($this->stubPath,$this->targetPath,[
            "modelName" =>$this->modelName,
            "actionName" => Str::lower($this->actionLabel),
            "actionLabel" => $this->actionLabel,
            "moduleName" =>$this->moduleName,
            "resourceName" =>$this->resourceName
        ]);
    }
}
