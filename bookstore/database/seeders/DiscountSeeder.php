<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $discounts = [
            [
                'id' => 1,
                'code' => 'MAHETLUOT',
                'discount' => 100000,
                'limit_number' => 30,
                'number_used' => 30,
                'expiration_date' => '2024-09-29',
                'payment_limit' => 500000,
                'description' => 'Giam 100000',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'code' => 'MAHOIVIEN',
                'discount' => 150000,
                'limit_number' => 68,
                'number_used' => 23,
                'expiration_date' => '2024-06-30',
                'payment_limit' => 500000,
                'description' => 'Giam 300k',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'code' => 'CAUTHANH5',
                'discount' => 150000,
                'limit_number' => 200,
                'number_used' => 0,
                'expiration_date' => '2024-09-29',
                'payment_limit' => 500000,
                'description' => 'Giam 150k',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'code' => 'MANEW89',
                'discount' => 200000,
                'limit_number' => 300,
                'number_used' => 103,
                'expiration_date' => '2024-07-20',
                'payment_limit' => 500000,
                'description' => ' giảm 200k',
                'created_by' => 1,
                'created_at' => now()
            ],
        ];


        DB::table('discounts')->insert($discounts);
    }
}
