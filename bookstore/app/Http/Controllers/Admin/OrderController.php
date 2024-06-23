<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;
use App\Services\OrderStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $orderRepository;

    private $orderProductRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderProductRepositoryInterface $orderProductRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $total_trash = $this->orderRepository->totalTrash();
        $orders = $this->orderRepository->getAllOrder();
        return view('admin.orders.index', compact('total_trash', 'orders'));
    }


    /**
     * @param  OrderStatusRequest  $request
     * @param $id
     * @return RedirectResponse
     */
    public function orderStatusUpdate(OrderStatusRequest $request, $id): RedirectResponse
    {
        try {
            $orderStatus = $request->validated();
            if (isset($orderStatus['status']) && $orderStatus['status'] == Order::DELIVERED) {
                $orderStatus['payment_status'] = Order::PAID;
            }
            $this->orderRepository->updateOrder($id, $orderStatus);
        } catch (\Exception $e) {
            record_error_log($e);
            return back();
        }

        toastr()->success(__('Cập nhật trạng thái đơn hàng thành công'), 'Thông báo');
        return back();
    }


    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $order = $this->orderRepository->getOrderById($id);

        return view('admin.orders.detail', compact('order'));
    }


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {
            $order = $this->orderRepository->getOrderById($id);
            if ($order && $order->status == config('constants.order_status.delivering')) {
                toastr()->warning(__('Đơn hàng '.$order->code.' đang được giao, không thể lưu !'), 'Thông báo');
                return back();
            }
            $this->orderRepository->delete($id);
        } catch (\Exception $e) {
            record_error_log($e);
            return back();
        }

        toastr()->success(__('Lưu đơn hàng thành công'), 'Thông báo');
        return back();
    }

    public function recyclebin()
    {
        $orders = $this->orderRepository->getOnlyTrashed();
        return view('admin.orders.recyclebin', compact('orders'));
    }

    public function display($id)
    {
        $order = $this->orderRepository->getOrderTrashById($id);
        return view('admin.orders.detail', compact('order'));
    }

    public function restore($id)
    {
        try {
            $this->orderRepository->restoreOrderById($id);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
        }
        toastr()->success(__('Khôi phục thành công'), 'Thông báo');
        return back();
    }

    public function foreverDelete($id)
    {
        try {
            $this->orderRepository->foreverDeleteOrderById($id);
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi'), 'Thông báo');
            return back();
        }
        toastr()->success(__('Xóa thành công'), 'Thông báo');
        return back();
    }
}
