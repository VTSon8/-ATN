<?php

namespace App\Repositories\OrderProduct;

use App\Models\OrderProduct;
use App\Repositories\BaseRepository;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{

    public function getAllOrderProduct()
    {
        return OrderProduct::all();
    }

//    public function update($id, $params)
//    {
//        return OrderProduct::find($id)->update($params);
//    }

    public function getModel()
    {
        return OrderProduct::class;
    }
}
