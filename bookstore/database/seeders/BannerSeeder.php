<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            [
                'id' => 1,
                'name' => 'XIAOMI PAD 6',
                'thumb' => 'mo-ban-xiaomi-pad-6-slide.jpg',
                'description' => 'Mở bán giá tốt',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'OPPO RENO10',
                'thumb' => '78FD7174-0C85-4E5D-A07D-4BD660CA.jpg',
                'description' => 'Dẫn đầu xu hướng',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'TIVI XIAOMI MỚI',
                'thumb' => 'a-pro-series-sliding-00111.jpg',
                'description' => 'Mở bán chỉ từ 9.99 triệu',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'JBL TOUR PRO 2',
                'thumb' => 'pre-tai-nghe-jbl-tour-pro2-slide.jpg',
                'description' => 'Ưu đãi cực khủng',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'CHÀO ĐÓN S-ANT',
                'thumb' => 'linh-vat-sliding-1.jpg',
                'description' => 'Chơi game chúng lớn',
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 6,
                'name' => 'APPLE IPAD',
                'thumb' => 'ipad-home-sliding-011.jpg',
                'description' => 'Mở bán giá rẻ',
                'created_by' => 1,
                'created_at' => now()
            ],
        ];

        DB::table('banners')->insert($banners);
    }
}
