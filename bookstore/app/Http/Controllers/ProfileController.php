<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\UploadImage;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $orderRepository;
    private $productRepository;
    private $orderProductRepository;
    private $uploadImage;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        OrderProductRepositoryInterface $orderProductRepository,
        UploadImage $uploadImage
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->uploadImage = $uploadImage;
    }

    public function profile(Request $request, $info = null)
    {
        $orderPending = Order::where('customer_id', $request->user()->id)->pending()->get();
        $orderProcess = Order::where('customer_id', $request->user()->id)->process()->get();

        return view('profile', compact('info', 'orderPending', 'orderProcess'));
    }
    public function cancel(Request $request, $id)
    {
        try {
            $order = Order::query()->findOrFail($id);

            if (in_array($order->status, [Order::DELIVERING, Order::DELIVERED])) {
                toastr()->warning(__('Đơn hàng đang trong quá trình giao hàng không thể hủy'), 'Thông báo');
                return back();
            }

            $order->status = Order::CUSTOMER_CANCEL;
            $order->save();
        } catch (\Exception $e) {
            record_error_log($e);
            toastr()->error(__('Đã xảy ra lỗi vui lòng thực hiện lại'), 'Thông báo');
            return back();
        }

        toastr()->info(__("Bạn đã hủy đơn hàng #$order->code thành công"), 'Thông báo');
        return back();
    }
}
