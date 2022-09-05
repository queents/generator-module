<?php


namespace Modules\Generator\Services;


use Modules\Generator\Interfaces\GeneratorInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
/**
 * Class ModelGenerator
 * @package Modules\Generator\Services
 */
class PermissionGenerator implements GeneratorInterface
{

    public function __construct(
                public string $tableName,
    )
    {
    }

    /*
     * do nothing :)
     * */
    public function generateModelName()
    {
        // TODO: Implement generateModelName() method.
    }

    /*
     *  check if  permission is granted
     *  if not granted create new permission
     *  assign permission to admin role
     * */

    public function generate()
    {

        $checkView = Permission::where('name', 'view_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkView) {
            Permission::create(['name' => 'view_' . $this->tableName, 'guard_name' => 'web']);
        }
        $checkViewAny = Permission::where('name', 'view_any_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkViewAny) {
            Permission::create(['name' => 'view_any_' . $this->tableName, 'guard_name' => 'web']);
        }
        $checkCreate = Permission::where('name', 'create_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkCreate) {
            Permission::create(['name' => 'create_' . $this->tableName, 'guard_name' => 'web']);
        }
        $checkUpdate = Permission::where('name', 'update_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkUpdate) {
            Permission::create(['name' => 'update_' . $this->tableName, 'guard_name' => 'web']);
        }
        $checkDelete = Permission::where('name', 'delete_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkDelete) {
            Permission::create(['name' => 'delete_' . $this->tableName, 'guard_name' => 'web']);
        }
        $checkExport = Permission::where('name', 'export_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkExport) {
            Permission::create(['name' => 'export_' . $this->tableName, 'guard_name' => 'web']);
        }
        $checkDeleteAny = Permission::where('name', 'delete_any_' . $this->tableName)->where('guard_name', 'web')->first();
        if (!$checkDeleteAny) {
            Permission::create(['name' => 'delete_any_' . $this->tableName, 'guard_name' => 'web']);
        }

        $checkIfAdminIsExist = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        if (!$checkIfAdminIsExist) {
            $checkIfAdminIsExist = Role::create([
                "name" => "admin",
                "guard_name" => "web"
            ]);
        }

        $checkIfAdminIsExist->givePermissionTo('view_' . $this->tableName);
        $checkIfAdminIsExist->givePermissionTo('view_any_' . $this->tableName);
        $checkIfAdminIsExist->givePermissionTo('create_' . $this->tableName);
        $checkIfAdminIsExist->givePermissionTo('update_' . $this->tableName);
        $checkIfAdminIsExist->givePermissionTo('delete_' . $this->tableName);
        $checkIfAdminIsExist->givePermissionTo('delete_any_' . $this->tableName);
        $checkIfAdminIsExist->givePermissionTo('export_' . $this->tableName);

    }
}
