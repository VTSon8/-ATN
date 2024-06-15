<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function getAllOrder();

    public function getOrderById($id);

    public function updateOrder($id, array $params);

    public function delete($id);

    public function restoreOrderById($id);

    public function foreverDeleteOrderById($id);

    public function totalTrash();

    public function getOnlyTrashed();

    public function getOrderTrashById($id);


}
