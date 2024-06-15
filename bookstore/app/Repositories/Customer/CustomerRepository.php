<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function getAllCustomer()
    {
        return Customer::query()->paginate(config('constants.pagination'));
    }

    public function getCustomerById($id)
    {
        return Customer::whereId($id)->first();
    }

    public function updateCustomer($id, array $params)
    {
        return Customer::whereId($id)->update($params);
    }

    public function delete($id)
    {
        return Customer::whereId($id)->delete($id);
    }

    public function restoreCustomerById($id)
    {
        return Customer::withTrashed()->whereId($id)->restore();
    }

    public function getCustomerByIdOnlyTrashed($id)
    {
        return Customer::withTrashed()->whereId($id)->first();
    }

    public function foreverDeleteCustomerById($id)
    {
        return Customer::withTrashed()->whereId($id)->forceDelete();
    }

    public function totalTrash()
    {
        return Customer::onlyTrashed()->count();
    }

    public function getOnlyTrashed()
    {
        return Customer::onlyTrashed()->paginate(config('constants.pagination'));
    }

    public function getModel()
    {
       return Customer::class;
    }
}
