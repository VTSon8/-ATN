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

//    public function updateProfile(UpdateProfileRequest $request): \Illuminate\Http\RedirectResponse
//    {
//        DB::beginTransaction();
//        try {
//            $infoCustomer = $request->validated();
//            $emailCustomer = $infoCustomer['email'] ?? $request->user()->email;
//            unset($infoCustomer['email']);
//            $customer = Customer::where('email', $emailCustomer)->lockForUpdate()->first();
//            if (!$customer) {
//                abort(404);
//            }
//
//            if (isset($infoCustomer['avatar'])) {
//                $infoCustomer['avatar'] = $this->uploadImage->handleUploadedImage($infoCustomer['avatar']);
//                $this->uploadImage->handleUnlinkImage($customer->avatar);
//            }
//            $customer->update($infoCustomer);
//            DB::commit();
//        } catch (\Exception $e) {
//            DB::rollBack();
//            record_error_log($e);
//            abort(503);
//        }
//
//        toastr()->info(__('Cập nhật thông tin tài khoản thành công'), 'Thông báo');
//        return back();
//    }
//
//    public function detail(Request $request, $id)
//    {
//        $order = Order::where('id', $id)->where('customer_id', $request->user()->id)->first();
//        $order_detail = OrderProduct::query()
//            ->where('order_id', $order->id)
//            ->get();
//
//        return view('profile.detail', compact('order', 'order_detail'));
//    }
//
//    public function reviews(Request $request, $id)
//    {
//        $orderId = $id;
//        $order_detail = OrderProduct::query()
//            ->where('order_id', $id)
//            ->get();
//
//        return view('profile.reviews', compact('orderId', 'order_detail'));
//    }
//
//    public function reviewsStore(ReviewRequest $request, $id)
//    {
//        DB::beginTransaction();
//        try {
//            $review = $request->validated();
//            $review['customer_id'] = optional($request->user())->id ?? auth()->user()->id;
//            Review::create($review);
//            OrderProduct::where('order_id', $id)->where('product_id',
//                $review['product_id'])->first()->update(['rating_status' => 1]);
//            $avgRate = round(Review::where('product_id', $review['product_id'])->avg('rate'), 1);
//            $this->productRepository->updateProduct($review['product_id'], ['avg_rate' => $avgRate]);
//            DB::commit();
//        } catch (\Exception $e) {
//            DB::rollBack();
//            record_error_log($e);
//            toastr()->error(__('Lỗi hệ thống'), 'Thông báo');
//            return back();
//        }
//
//        toastr()->info(__('Cảm ơn quý khách đã đánh giá sản phẩm.'), 'Thông báo');
//        return back();
//    }
//
//    public function cancel(Request $request, $id)
//    {
//        try {
//            DB::beginTransaction();
//            $order = Order::query()->findOrFail($id);
//
//            if (in_array($order->status, [Order::DELIVERING, Order::DELIVERED])) {
////                $this->orderRepository->updateOrder($id, ['status' => Order::CUSTOMER_CANCEL]);
////                $order->update(['status' => Order::CUSTOMER_CANCEL]);
//                toastr()->warning(__('Đơn hàng đang trong quá trình giao hàng không thể hủy'), 'Thông báo');
//                return back();
//            }
//
//            $order->status = Order::CUSTOMER_CANCEL;
//            $order->save();
//            DB::commit();
//        } catch (\Exception $e) {
//            DB::rollBack();
//            record_error_log($e);
//            toastr()->error(__('Đã xảy ra lỗi vui lòng thực hiện lại'), 'Thông báo');
//            return back();
//        }
//
//        toastr()->info(__("Bạn đã hủy đơn hàng #$order->code thành công"), 'Thông báo');
//        return back();
//    }
}
