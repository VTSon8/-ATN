<?php

namespace App\Repositories\Supplier;

interface SupplierRepositoryInterface
{
    public function getAllSupplier();

    public function createSupplier(array $params);

    public function getSupplierById($id);

    public function updateSupplier($id, array $params);

    public function deleteSupplier($id);

}
