<?php

namespace App\Repositories\Supplier;

use App\Models\Category;
use App\Models\Supplier;
use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function getAllSupplier()
    {
        return $this->model->query()->get();
    }

    public function createSupplier(array $params)
    {
        return $this->model->create($params);
    }

    public function getSupplierById($id)
    {
        return $this->model->query()->whereId($id)->first();
    }

    public function updateSupplier($id, array $params)
    {
        return $this->model->whereId($id)->update($params);
    }

    public function deleteSupplier($id)
    {
        return $this->model->destroy($id);
    }

    public function getModel()
    {
        return Supplier::class;
    }
}
