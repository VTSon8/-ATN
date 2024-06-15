<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ownerRole = Role::create(['name' => 'owner', 'guard_name' => 'admin']);
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $viewerRole = Role::create(['name' => 'viewer', 'guard_name' => 'admin']);

        $getAllPermisstion  = Permission::all()->pluck('id')->toArray();
        $getAllPermisstionAdmin  = Permission::where('name', '<>', 'forever_delete')->pluck('id')->toArray();
        $getAllPermisstionViewer = Permission::whereIn('name', ['read', 'import_goods', 'soft_delete'])->pluck('id')->toArray();
        $getAllPermisstionOwner  = Permission::whereIn('name', ['read'])->pluck('id')->toArray();
        $superAdminRole->syncPermissions($getAllPermisstion);
        $adminRole->syncPermissions($getAllPermisstionAdmin);
        $viewerRole->syncPermissions($getAllPermisstionViewer);
        $ownerRole->syncPermissions($getAllPermisstionOwner);
    }
}
