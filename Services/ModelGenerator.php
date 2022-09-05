<?php


namespace Modules\Generator\Services;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Modules\Generator\Interfaces\GeneratorInterface;
use phpDocumentor\Reflection\Types\This;

/**
 * Class ModelGenerator
 * @package Modules\Generator\Services
 */
class ModelGenerator implements GeneratorInterface {

    private ?string $modelName;

    /**
     * ModelGenerator constructor.
     * @param string $tableName
     * @param string $moduleName
     */
    public function __construct(
        public string $tableName,
        public string $moduleName
    )
    {
        $this->generateModelName();
    }

    /**
     *
     * convert table name (table name with s and _) to model camelCase
     */
    public function generateModelName(): void
    {
        $this->modelName = ucfirst(Str::camel(Str::singular($this->tableName)));
    }

    /**
     * call krlove plugin artisan command to generate model with it's relation
     */
    public function generate(): void
    {
        $command = 'krlove:generate:model ' . $this->modelName . ' --table-name=' . $this->tableName . ' --output-path=' . module_path($this->moduleName) . '/Entities' . ' --namespace=' . "Modules" . "\\\\" . $this->moduleName . "\\\\" . "Entities";
        Artisan::call($command);
    }
}
