<?php

namespace App\Repositories\Customer;
interface  CustomerRepositoryInterface {
    public function getAllCustomer();

    public function getCustomerById($id);

    public function updateCustomer($id, array $params);

    public function delete($id);

    public function restoreCustomerById($id);
    public function getCustomerByIdOnlyTrashed($id);

    public function foreverDeleteCustomerById($id);

    public function totalTrash();

    public function getOnlyTrashed();
}
