<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function getAllOrder()
    {
        return Order::query()->latest('created_at')->paginate(config('constants.pagination'));
    }

    public function getOrderById($id)
    {
        return Order::with('province:id,name')
            ->with('district:id,name,prefix')
            ->with('ward:id,name,prefix')
            ->with([
                'products' => function ($query) {
                    $query->select('name', 'selling_price', 'quantity', 'price');
                }
            ])
            ->find($id);
    }

    public function updateOrder($id, $params)
    {
        return Order::find($id)->update($params);
    }

    public function delete($id)
    {
        return Order::whereId($id)->delete();
    }

    public function restoreOrderById($id)
    {
        return Order::withTrashed()->whereId($id)->restore();
    }

    public function foreverDeleteOrderById($id)
    {
        return Order::withTrashed()->whereId($id)->forceDelete();
    }

    public function totalTrash()
    {
        return Order::onlyTrashed()->count();
    }

    public function getOnlyTrashed()
    {
        return Order::onlyTrashed()->paginate(config('constants.pagination'));
    }

    public function getOrderTrashById($id)
    {
        return Order::onlyTrashed()->with('province:id,name')
            ->with('district:id,name,prefix')
            ->with('ward:id,name,prefix')
            ->with([
                'products' => function ($query) {
                    $query->select('name', 'selling_price', 'quantity', 'price');
                }
            ])
            ->find($id);
    }

    public function getModel()
    {
       return Order::class;
    }
}
