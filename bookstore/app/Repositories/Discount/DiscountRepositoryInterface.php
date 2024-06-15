<?php

namespace App\Repositories\Discount;

interface DiscountRepositoryInterface {
    public function getAllDiscount();
    public function createDiscount(array $params);
    public function getDiscountById($id);
    public function updateDiscount($id, array $params);
    public function getDiscountByCode($code);
    public function deleteDiscount($id);

}
