<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'id' => 1,
                'name' => 'NXB Trẻ',
                'representative_name' => 'Nguyễn Thành Long',
                'email' => 'thanhlong@gmail.com',
                'phone' => '0323244344',
                'address' => '45 Nam Thanh',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Trí Việt',
                'representative_name' => 'Lê Thanh Sơn',
                'email' => 'lethanhson@gmail.com',
                'phone' => '0323244344',
                'address' => '45 Nam Thanh',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'name' => ' Minh Tâm',
                'representative_name' => 'Nguyễn Văn Nam',
                'email' => 'nguyenvannam@gmail.com',
                'phone' => '0323244344',
                'address' => '45 Nam Thanh',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
