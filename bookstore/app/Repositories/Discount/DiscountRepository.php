<?php

namespace App\Repositories\Discount;

use App\Models\Discount;
use App\Models\Product;
use App\Repositories\BaseRepository;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    public function getAllDiscount()
    {
        return Discount::query()->get();
    }

    public function createDiscount(array $params)
    {
        return Discount::create($params);
    }

    public function getDiscountById($id)
    {
        return Discount::query()->where('id', $id)->first();
    }

    public function updateDiscount($id, array $params)
    {
        return Discount::whereId($id)->update($params);
    }

    public function getDiscountByCode($code)
    {
        $discount = Discount::query()
            ->where('code', $code)
            ->where('status', 1)
            ->first();

        return $discount;
    }

    public function deleteDiscount($id)
    {
        return Discount::whereId($id)->delete();
    }


    public function getModel()
    {
        return Discount::class;
    }
}
