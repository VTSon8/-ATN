<?php

namespace App\Repositories\OrderProduct;

interface OrderProductRepositoryInterface
{
    public function getAllOrderProduct();

    public function update($id, array $params);

}
