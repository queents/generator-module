<?php


namespace Modules\Generator\Services\TraitsGenerator;


use Modules\Generator\Interfaces\GeneratorInterface;
use Modules\Generator\Services\Helpers\CanManipulateFiles;

class TranslationsGenerator implements GeneratorInterface
{
    use CanManipulateFiles;

    private string $stubPath;
    private string $targetPath;

    public function __construct(
        private string $headerTranslationName,
        private string $fieldsTranslationName,
        private string $resourceName,
        private string $moduleName,

    )
    {
        $this->generateModelName();

    }


    public function generateModelName()
    {
        $this->folderDirectory =["/Vilt","/Resources","/".$this->resourceName,"/Traits"];
        $this->stubPath ="Resources/ModuleResource/Traits/ModuleTranslations";
        $this->targetPath =module_path($this->moduleName).  '/Vilt/Resources/' . $this->resourceName . 'Resource/Traits/Translations.php';
    }

    public function generate()
    {
        $this->checkForCollision();
        $this->copyStubToApp($this->stubPath,$this->targetPath,[
            "headerTranslationName" =>$this->headerTranslationName,
            "fieldsTranslationName" => $this->fieldsTranslationName,
            "resourceClass" => $this->resourceName.'Resource',
            "module" => $this->moduleName,
        ]);
    }
}
