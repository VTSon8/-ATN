<?php

return [
    'vnp_tmn_code' => env('VNP_TMN_CODE'),
    'vnp_hash_secret' => env('VNP_HASH_SECRET'),
    'vnp_url' => "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
    'vnp_return_url' => "/checkout/vnPayCheck",
    'roles' => [
        10 => 'viewer',
        100 => 'admin',
        120 => 'super-admin',
        150 => 'owner'
    ],

    'roles_name' => [
        10 => 'Nhân viên',
        100 => 'Chủ cửa hàng',
//        120 => 'Quản trị viên',
        150 => 'Người quản lý'
    ],

    'order_status' => [
        'pending' => 0,
        'delivering' => 1,
        'delivered' => 2,
        'customer_cancel' => 3,
        'staff_cancel' => 4,
    ],

    'role' => [
        'owner' => 150,
        'super-admin' => 120,
        'admin' => 100,
        'viewer' => 10,
    ],

    'account_status' => [
        1 => 'Kích hoạt',
        0 => 'Chưa kích hoạt',
    ],

    'USER_ROLE' => [
        'SUPER_ADMIN' => 1,
        'ADMIN' => 2,
    ],
    'CATEGORY_STATUS' => [
        'STOP' => 0,
        'PROGRESS' => 1
    ],
    'supplier_STATUS' => [
        'publish' => 0,
        'unpublished' => 1
    ],
    'PER_PAGE' => 12,
    'pagination' => 10,
    'SHOW_POST' => 2,
    'SHOW_BANNER' => 6,
    'api_key_google_map' => 'AIzaSyD3GG7Qq1XgRMAcjPejT9spgnR4RZ9xzbU',
    'api_key_google_map_v1' => env('GOOGLE_MAP_KEY'),
];
