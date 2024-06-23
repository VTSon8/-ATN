<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OrderMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Services\CartService;
use App\Services\LocationService;
use App\Utilities\VNPay;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
    private $locationService;

    private $cartService;

    public function __construct(
        DiscountRepositoryInterface $discountRepository,
        CartService $cartService,
        LocationService $locationService
    ) {
        $this->discountRepository = $discountRepository;
        $this->cartService = $cartService;
        $this->locationService = $locationService;
    }

    public function index($id = null)
    {
        if (Auth::guest()) {
            toastr()->info(__('Bạn cần đăng nhập để thực hiện đặt hàng'), 'Thông báo');
            return back();
        }

        return view('checkout');
    }

    public function order(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $bill = $request->only(['name', 'phone', 'address', 'payment_type']);
            $bookPurchaseData = $this->cartService->getData();
            $discount = $this::getItem('discount') ?? 0;
            $transportFee = $this::getItem('transport_fee') ?? 0;
            $bill['code'] = Str::random(9);
            $bill['discount'] = $discount;
            $bill['fee'] = $transportFee;
            $bill['customer_id'] = Auth::user()->id;
            $bill['amount'] = ($bookPurchaseData['total_money'] - $discount) + $transportFee;
            $order = Order::create($bill);
            $dataList = array_map(function ($item) use ($order) {
                return array_merge($item, ['order_id' => $order->id]);
            }, $bookPurchaseData['data']);
            OrderProduct::insert($dataList);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            record_error_log($e);
            return back();
        }

        if ($bill['payment_type'] == 1) {
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id,
                'vnp_OrderInfo' => "Mã đơn hàng: #$order->code",
                'vnp_Amount' => $order->amount,
            ]);

            return redirect()->to($data_url);
        }

        $this::deleteItem('discount');
        $this::deleteItem('transport_fee');
        $this->cartService->flashCart();
        return redirect()->route('bill');
    }

    public function vnPayCheck(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');
        $vnp_Amount = $request->get('vnp_Amount');
        try {
            if ($vnp_ResponseCode != null) {
                if ($vnp_ResponseCode == 0) {
                    $orderNew = Order::findOrFail($vnp_TxnRef);
                    $orderNew->update(['payment_status' => Order::PAID, 'status' => Order::PREPARE]);
//                Product::update($bookPurchaseData['recalculate_product_quantity']);
                    $this::deleteItem('discount');
                    $this::deleteItem('transport_fee');
                    $this->cartService->flashCart();

                    return redirect()->route('bill');
                } elseif ($vnp_ResponseCode == 24) {
                    Order::findOrFail($vnp_TxnRef)->delete();
                    toastr()->warning(__('Bạn đã hủy giao dịch thanh toán trực tuyến!'), 'Thông báo');
                    return redirect()->route('checkout.index');
                } else {
                    Order::findOrFail($vnp_TxnRef)->delete();
                    toastr()->error(trans('payment.error_vnPay'), 'Thông báo');
                    return redirect()->route('checkout.index');
                }
            }
        } catch (\Exception $e) {
            record_error_log($e);
        }
    }

    /**
     * @param $orderNew
     * @return RedirectResponse
     */
    private function hanldeOnlinePayment($orderNew): \Illuminate\Http\RedirectResponse
    {
        $data_url = VNPay::vnpay_create_payment([
            'vnp_TxnRef' => $orderNew->id,
            'vnp_OrderInfo' => "Mã đơn hàng: #$orderNew->code",
            'vnp_Amount' => $orderNew->price,
        ]);

        return redirect()->to($data_url);
    }


    /**
     * @return JsonResponse
     */
    public function getProvinces(): JsonResponse
    {
        $provinces = $this->locationService->getProvinces();

        return response()->json(['items' => $provinces], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDistricts($id): JsonResponse
    {
        $districts = $this->locationService->getDistricts($id);

        return response()->json(['items' => $districts], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getWards($id): \Illuminate\Http\JsonResponse
    {
        $wards = $this->locationService->getWards($id);

        return response()->json(['items' => $wards], 200);
    }


}
