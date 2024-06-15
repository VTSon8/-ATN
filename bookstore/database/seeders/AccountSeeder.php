<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->truncate();

        $customer = Customer::create([
            'name' => 'truongson',
            'email' => 'truongson@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $customer = Customer::create([
            'name' => 'truongson',
            'email' => 'truongson+1@gmail.com',
            'birthday' => now(),
            'phone' => '0326552599',
            'address' => '52/2 Thoại Ngọc Hầu, Phường Hòa Thạnh, Quận Tân Phú, Hồ Chí Minh',
            'password' => Hash::make('12345678'),
        ]);

        $owner = Account::create([
            'name' => 'Owner',
            'email' => 'owner@testmail.com',
            'role_id' => 150,
            'password' => Hash::make('12345678'),
        ]);
        $owner->assignRole(config('constants.roles')[$owner->role_id]);

        $supadmin = Account::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@testmail.com',
            'role_id' => 120,
            'password' => Hash::make('12345678'),
            'created_by' => $owner->id,
        ]);
        $supadmin->assignRole(config('constants.roles')[$supadmin->role_id]);

        $admin = Account::create([
            'name' => 'Admin',
            'email' => 'admin@testmail.com',
            'role_id' => 100,
            'password' => Hash::make('12345678'),
            'created_by' => $supadmin->id,
        ]);
        $admin->assignRole(config('constants.roles')[$admin->role_id]);

        $viewer = Account::create([
            'name' => 'Viewer',
            'email' => 'viewer@testmail.com',
            'role_id' => 10,
            'password' => Hash::make('12345678'),
            'created_by' => $admin->id,
        ]);
        $viewer->assignRole(config('constants.roles')[$viewer->role_id]);

    }
}
