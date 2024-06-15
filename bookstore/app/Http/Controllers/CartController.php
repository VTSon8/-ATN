<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountCodeRequest;
use App\Models\Product;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\CartService;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{

    private $productRepository;
    private $discountRepository;
    private $cartService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        DiscountRepositoryInterface $discountRepository,
        CartService $cartService
    ) {
        $this->productRepository = $productRepository;
        $this->discountRepository = $discountRepository;
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request, $id)
    {
        $qty = (int)$request->quantity ?? 1;
        $this->cartService->handleAddToCart((int)$id, $qty);

        return response()->json($this->getCart(), 200);
    }

    public function cartList()
    {
        return response()->json($this->getCart(), 200);
    }

    public function getCart()
    {
        $cart = Cart::content() ?? [];
        $dataList = [];
        $seconds = 600 * 10;
        $totalMoney = 0;
        foreach ($cart as $index => $book) {
            $intoMoney = (int)data_get($book, 'price') * data_get($book, 'qty');
            $totalMoney = $totalMoney + $intoMoney;
            $dataList[] = [
                'id' => data_get($book, 'id'),
                'cart_sku' => $index,
                'name' => data_get($book, 'name'),
                'promotion' => data_get($book, 'options.sale'),
                'qty' => data_get($book, 'qty'),
                'image_url' => url('assets/upload/'.data_get($book, 'options.image')),
                'price' => number_format(data_get($book, 'price')),
                'into_money' => number_format($intoMoney),
                'url' => URL::temporarySignedRoute(
                    'product.details',
                    $seconds,
                    ['slug' => data_get($book, 'options.slug', '')]
                ),
            ];
        }
        $numberBook = $cart->count() ?? 0;

        return ['items' => $dataList, 'total_money' => number_format($totalMoney), 'number' => $numberBook];
    }

    public function show()
    {
        $carts = Cart::content();
        $totalPrice = intval(str_replace(',', '', Cart::total()));
        return view('cart', compact('carts', 'totalPrice'));
    }

    public function update(Request $request)
    {
        try {
            $items = $request->items ?? [];
            foreach ($items as $index => $item) {
                Cart::update($index, [
                    'qty' => (int)$item,
                ]);
            }

            return response()->json($this->getCart(), 200);
        } catch (\Throwable $e) {
            record_error_log($e);
            return response()->json(503, 'NG', []);
        }
    }

    public function removeBookByCart($id = null)
    {
        try {
            Cart::remove($id);
        } catch (\Throwable $e) {
            record_error_log($e);
        }

        return back();
    }

    public function remove(Request $request)
    {
        try {
            Cart::remove($request->id);

            return response()->json($this->getCart(), 200);
        } catch (\Throwable $e) {
            record_error_log($e);

            return response()->json(['status' => false, 'message' => $e->getMessage()], 503);
        }
    }

    public function applyCoupon(DiscountCodeRequest $request)
    {
        if (session()->has('coupon')) {
            return response()->json(404, 'NG', ['message' => trans('messages.unique_code')]);
        }

        $code = $request->validated();
        $responseData = [];
        $total_price = intval(str_replace(',', '', Cart::total()));
        $coupon = $this->discountRepository->getDiscountByCode(data_get($code, 'code'));

        if (!$coupon) {
            return response()->json(404, 'NG', ['message' => trans('messages.valid')]);
        }

        if ($coupon->expiration_date < now()) {
            $responseData['message'] = trans(
                'messages.coupon_expired',
                ['code' => $coupon->code, 'date' => $coupon->expiration_date]
            );
        } elseif ($coupon->limit_number - $coupon->number_used == 0) {
            $responseData['message'] = trans('messages.coupon_used_up', ['code' => $coupon->code]);
        } elseif ($coupon->payment_limit >= $total_price) {
            $responseData['message'] = trans(
                'messages.coupon_limit_message',
                ['payment_limit' => number_format($coupon->payment_limit)]
            );
        } else {
            $couponData = [
                'code' => $coupon->code,
                'discount' => $coupon->discount
            ];
            session()->put('coupon', $couponData);
            return response()->json(200, 'OK', $couponData);
        }

        return response()->json(404, 'NG', $responseData);
    }

    public function removeCoupon()
    {
        if (session()->has('coupon')) {
            session()->forget('coupon');
        }

        return response()->json(200, 'OK', []);
    }


}
