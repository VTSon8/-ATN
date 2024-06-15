<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'Sách Kinh Tế',
                'slug' => Str::slug('Sách Kinh Tế'),
                'description' => 'Danh mục sách Kinh Tế',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'Sách Văn Học Trong Nước',
                'slug' => Str::slug('Sách Văn Học Trong Nước'),
                'description' => 'Danh mục sách văn Học Trong Nước',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'parent_id' => null,
                'name' => 'Sách Thưởng Thức Đời Sống',
                'slug' => Str::slug('Sách Thưởng Thức Đời Sống'),
                'description' => 'Danh mục sách Thưởng Thức Đời Sống',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'parent_id' => null,
                'name' => 'Sách Thưởng Thức Đời Sống',
                'slug' => Str::slug('Sách Thưởng Thức Đời Sống'),
                'description' => 'Danh mục sách Thưởng Thức Đời Sống',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 5,
                'parent_id' => null,
                'name' => 'Sách Thiếu Nhi',
                'slug' => Str::slug('Sách Thiếu Nhi'),
                'description' => 'Danh mục sách Sách Thiếu Nhi',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 6,
                'parent_id' => null,
                'name' => 'Sách Phát Triển Bản Thân',
                'slug' => Str::slug('Sách Phát Triển Bản Thân'),
                'description' => 'Danh mục sách Sách Phát Triển Bản Thân',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 7,
                'parent_id' => null,
                'name' => 'Sách Tin Học Ngoại Ngữ',
                'slug' => Str::slug('Sách Tin Học Ngoại Ngữ'),
                'description' => 'Danh mục sách Sách Tin Học Ngoại Ngữ',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 8,
                'parent_id' => null,
                'name' => 'Sách Giáo Khoa - Giáo Trình',
                'slug' => Str::slug('Sách Giáo Khoa - Giáo Trình'),
                'description' => 'Danh mục sách Sách Giáo Khoa - Giáo Trình',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 9,
                'parent_id' => null,
                'name' => 'Sách Mới Phát Hành',
                'slug' => Str::slug('Sách Mới Phát Hành'),
                'description' => 'Danh mục sách Sách Mới Phát Hành',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 10,
                'parent_id' => 1,
                'name' => 'Ngoại Thương',
                'slug' => Str::slug('Ngoại Thương'),
                'description' => 'Danh mục sach ngoại Thương',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 11,
                'parent_id' => 1,
                'name' => 'Marketing - Bán Hàng',
                'slug' => Str::slug('Marketing - Bán Hàng'),
                'description' => 'Danh mục s Marketing - Bán Hàng',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 12,
                'parent_id' => 2,
                'name' => 'Nhân Vật Văn',
                'slug' => Str::slug('Nhân Vật Văn'),
                'description' => 'Danh mục Nhân Vật Văn',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 13,
                'parent_id' => 3,
                'name' => 'Cổ Tích & Thần Thoại',
                'slug' => Str::slug('Cổ Tích & Thần Thoại'),
                'description' => 'Danh mục Cổ Tích & Thần Thoại',
                'status' => true,
                'created_by' => 1,
                'created_at' => now()
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
