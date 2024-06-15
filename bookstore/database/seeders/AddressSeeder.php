<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $handle = fopen(database_path() . '/seeders/data/province.csv', 'r');
        $isHeader = false;
        while ($data = fgetcsv($handle)) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }
            DB::table('provinces')->insert(
                [
                    "id" => $data[0],
                    "name" => $data[1],
                    "code" => $data[2],
                ]
            );
        }

        $handle = fopen(database_path() . '/seeders/data/district.csv', 'r');
        $isHeader = false;
        while ($data = fgetcsv($handle)) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }
            DB::table('districts')->insert(
                [
                    "id" => $data[0],
                    "name" => $data[1],
                    "prefix" => $data[2],
                    "province_id" => $data[3],
                ]
            );
        }

        $handle = fopen(database_path() . '/seeders/data/ward.csv', 'r');
        $isHeader = false;
        while ($data = fgetcsv($handle)) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }
            DB::table('wards')->insert(
                [
                    "id" => $data[0],
                    "name" => $data[1],
                    "prefix" => $data[2],
                    "district_id" => $data[4],
                ]
            );
        }
    }
}
