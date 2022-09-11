<?php


namespace Modules\Generator\Services\ComponentGenerator;


use Illuminate\Support\Str;
use Modules\Generator\Interfaces\GeneratorInterface;
use Modules\Generator\Services\Helpers\CanManipulateFiles;

class ViewsGenerator implements GeneratorInterface
{
    use CanManipulateFiles;


    private string $actionLabel;
    private string $modelName;
    private array $folderDirectory;
    private string $targetPath;
    /**
     * ModelGenerator constructor.
     * @param string $actionName
     * @param string $moduleName
     */
    public function __construct(
        public string $actionName,
        public string $moduleName,
    )
    {
        $this->generateModelName();
    }

    public function generateModelName()
    {
        $this->modelName = ucfirst(Str::camel($this->actionName));
        $this->targetPath = module_path($this->moduleName) . "/Resources/views/{$this->modelName}";
        $this->folderDirectory = ["/Resources/view/{$this->modelName}"];
        $this->actionLabel =trim(ucwords(implode(' ',preg_split('/(?=[A-Z])/', $this->modelName))));
    }

    public function generate()
    {
        $this->checkForCollision();

        $viewFile = module_path($this->moduleName).  '/Resources/views/' . $this->modelName . '/View.vue';
        $editFile = module_path($this->moduleName).  '/Resources/views/' . $this->modelName . '/Edit.vue';
        $createFile = module_path($this->moduleName).  '/Resources/views/' . $this->modelName . '/Create.vue';

        $viewStub = "Vue/View";
        $editStub = "Vue/Edit";
        $createStub = "Vue/Create";

        $this->copyStubToApp($viewStub,$viewFile,[
            "tableName" =>$this->actionName,
            "titleLabel" =>Str::ucfirst(Str::singular($this->modelName)),
            "actionLabel" => $this->actionLabel,
            "moduleName" =>$this->moduleName,
        ]);

        $this->copyStubToApp($editStub,$editFile,[
            "tableName" =>$this->actionName,
            "titleLabel" =>Str::ucfirst(Str::singular($this->modelName)),
            "actionLabel" => $this->actionLabel,
            "moduleName" =>$this->moduleName,
        ]);

        $this->copyStubToApp($createStub,$createFile,[
            "tableName" =>$this->actionName,
            "titleLabel" =>Str::ucfirst(Str::singular($this->modelName)),
            "actionLabel" => $this->actionLabel,
            "moduleName" =>$this->moduleName,
        ]);
    }
}
