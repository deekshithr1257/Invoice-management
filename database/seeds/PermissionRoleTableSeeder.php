<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $store_manager_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' 
                && substr($permission->title, 0, 5) != 'role_' 
                && substr($permission->title, 0, 11) != 'permission_' 
                && !str_ends_with($permission->title, '_delete');
        });
        Role::findOrFail(2)->permissions()->sync($store_manager_permissions);
    }
}
