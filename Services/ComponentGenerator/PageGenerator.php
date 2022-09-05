<?php


namespace Modules\Generator\Services\ComponentGenerator;


use Illuminate\Support\Str;
use Modules\Generator\Interfaces\GeneratorInterface;
use Modules\Generator\Services\Helpers\CanManipulateFiles;

class PageGenerator implements GeneratorInterface
{
    use CanManipulateFiles;


    private string $modelName;

    /**
     * ModelGenerator constructor.
     * @param string $tableName
     * @param string $moduleName
     */
    public function __construct(
        public string $actionName,
        public string $moduleName
    )
    {
        $this->generateModelName();
    }

    public function generateModelName()
    {
        $this->modelName = ucfirst(Str::camel($this->actionName));
        $this->actionLabel =trim(ucwords(implode(' ',preg_split('/(?=[A-Z])/', $this->modelName))));
        $this->folderDirectory =["/Pages"];
        $this->stubPath ="Pages/ModulePage";
        $this->targetPath =module_path($this->moduleName).  '/Pages/' . $this->modelName .'Page.php';
    }

    public function generate()
    {
        $this->checkForCollision();
        $this->copyStubToApp($this->stubPath,$this->targetPath,[
            "pathName" =>Str::lower($this->modelName),
            "modelName" =>$this->modelName,
            "moduleName" =>$this->moduleName
        ]);
    }
}
