<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'read',
            'read_notice',
            'edit',
            'import_goods',
            'soft_delete',
            'forever_delete',
            'view-logs',
        ];
        $insert = [];
        foreach ($permissions as $permission) {
            $insert[] = [
                'name' => $permission,
                'guard_name' => 'admin',
            ];
        }
        Permission::insert($insert);
    }
}
