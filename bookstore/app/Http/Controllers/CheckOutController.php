<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OrderMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Services\CartService;
use App\Utilities\VNPay;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckOutController extends Controller
{

    private $discountRepository;
    private $provinceRepo;
    private $districtRepo;
    private $wardRepo;

    private $cartService;

    public function __construct(
//        ProvinceRepositoryInterface $provinceRepo,
//        DistrictRepositoryInterface $districtRepo,
//        WardRepositoryInterface $wardRepo,
        DiscountRepositoryInterface $discountRepository,
        CartService $cartService
    ) {
//        $this->provinceRepo = $provinceRepo;
//        $this->districtRepo = $districtRepo;
//        $this->wardRepo = $wardRepo;
        $this->discountRepository = $discountRepository;
        $this->cartService = $cartService;
    }

    public function index($id = null)
    {
        if (Auth::guest()) {
            toastr()->info(__('Bạn cần đăng nhập để thực hiện đặt hàng'), 'Thông báo');
            return back();
        }

        if(!is_null($id)) {
            $qty = 1;
            $this->cartService->handleAddToCart((int)$id, $qty);
        }

        return view('checkout');
    }

    public function order(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $request->validated();
            $order['discount'] = 0;
            $shippingAddress = session('shipping_address');
            $shippingPrice = (int)session('shipping_price');
            if (empty($shippingAddress) || is_null($shippingPrice)) {
                toastr()->warning(__('Địa chỉ nhận hàng không đúng hoặc đơn vị giao hàng của chúng tôi không hỗ trợ'),
                    'Thông báo');
                return back();
            }

            if (session()->has('coupon')) {
                $code = session('coupon.code');
                $coupon = $this->discountRepository->getDiscountByCode($code);
                if ($coupon) {
                    $order['discount'] = $coupon->discount;
                    $coupon->update(['number_used' => $coupon->number_used + 1]);
                } else {
                    session()->forget('coupon');
                    return back()->with('info', __('Mã giảm giá hiện tại không khả dụng'));
                }
            }

            $total = intval(str_replace(',', '', Cart::total()));
            $order['code'] = Str::random(8);
            $order['customer_id'] = Auth::user()->id;
            $order['price'] = $total + $shippingPrice - $order['discount'];
            $order['price_ship'] = $shippingPrice;

            $orderNew = Order::create($order);

            $cartItems = Cart::content();

            foreach ($cartItems as $cart) {
                $orderProduct = OrderProduct::create(
                    [
                        'order_id' => $orderNew->id,
                        'product_id' => $cart->id,
                        'quantity' => $cart->qty,
                        'price' => (int)$cart->price * (int)$cart->qty,
                    ]
                );

                $orderProductNew[] = $orderProduct;
                $product = $orderProduct->product;
                $product->decrement('number', $orderProduct->quantity);
                $product->increment('number_buy', $orderProduct->quantity);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            record_error_log($e);
            return back();
        }

        if ($order['payment_type'] == 1) {
//            $this->hanldeOnlinePayment($orderNew);
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $orderNew->id,
                'vnp_OrderInfo' => "Mã đơn hàng: #$orderNew->code",
                'vnp_Amount' => $orderNew->price,
            ]);

            return redirect()->to($data_url);
        }

        $this->sendEmail($orderNew);
        session()->forget(['coupon', 'shipping_price', 'shipping_address']);
        Cart::destroy();

        return view('success-order', compact('orderNew', 'orderProductNew'));
    }

    public function vnPayCheck(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');
        $vnp_Amount = $request->get('vnp_Amount');

        if ($vnp_ResponseCode != null) {
            if ($vnp_ResponseCode == 0) {
                $orderNew = Order::findOrFail($vnp_TxnRef);
                $orderProductNew = OrderProduct::query()->where('order_id', $orderNew->id)->get();
                $orderNew->update(['payment_status' => Order::PAID, 'status' => Order::PREPARE]);
                $this->sendEmail($orderNew);
                session()->forget(['coupon', 'shipping_price', 'shipping_address']);
                Cart::destroy();

                return view('cart.success-order', compact('orderNew', 'orderProductNew'));
            } elseif ($vnp_ResponseCode == 24) {
                Order::findOrFail($vnp_TxnRef)->delete();
                toastr()->warning(__('Bạn đã hủy giao dịch thanh toán trực tuyến!'), 'Thông báo');
                return back();
            } else {
                Order::findOrFail($vnp_TxnRef)->delete();
                toastr()->error(trans('payment.error_vnPay'), 'Thông báo');
                return back();
            }
        }
    }

    private function hanldeOnlinePayment($orderNew)
    {
        $data_url = VNPay::vnpay_create_payment([
            'vnp_TxnRef' => $orderNew->id,
            'vnp_OrderInfo' => "Mã đơn hàng: #$orderNew->code",
            'vnp_Amount' => $orderNew->price,
        ]);

        return redirect()->to($data_url);
    }

    private function sendEmail($order)
    {
//        $email_to = $order->customer->email;
        $orderProduct = OrderProduct::query()->where('order_id', data_get($order, 'id'))->get();
        $this->dispatch(new SendOrderEmail($order, $orderProduct));
//        Mail::to($email_to)->send(new OrderMail($order, $orderProduct));
    }


    public function getProvinces()
    {
        $all = $this->provinceRepo->getAllProvince();

        return response()->json($all);
    }

    public function getDistricts($id)
    {
        $all = $this->districtRepo->getAllDistrictByProvince($id);

        return response()->json($all);
    }

    public function getWards($id)
    {
        $all = $this->wardRepo->getAllWardByDistricts($id);

        return response()->json($all);
    }


}
