<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AccountSeeder::class,
            AddressSeeder::class,
            CategorySeeder::class,
            DiscountSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
