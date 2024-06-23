<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountCodeRequest;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Services\CartService;

class DiscountController extends Controller
{

    private $discountRepository;
    private $cartService;

    public function __construct(
        DiscountRepositoryInterface $discountRepository,
        CartService $cartService
    ) {
        $this->discountRepository = $discountRepository;
        $this->cartService = $cartService;
    }

    public function applyDiscount(DiscountCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        $code = $request->validated();
        $responseData = [];
        $totalOrderAmount = $this->cartService->getTotalOrderAmount();
        $transportFee = $this::getItem('transport_fee') ?? 0;
        $coupon = $this->discountRepository->getDiscountByCode(data_get($code, 'code'));
        if (!$coupon) {
            return $this->response(404, 'NG', ['message' => trans('messages.valid')]);
        }

        if ($coupon->expiration_date < now()) {
            $responseData['message'] = trans(
                'messages.coupon_expired',
                ['code' => $coupon->code, 'date' => $coupon->expiration_date]
            );
        } elseif ($coupon->limit_number - $coupon->number_used == 0) {
            $responseData['message'] = trans('messages.coupon_used_up', ['code' => $coupon->code]);
        } elseif ($coupon->payment_limit > $totalOrderAmount) {
            $responseData['message'] = trans(
                'messages.coupon_limit_message',
                ['payment_limit' => number_format($coupon->payment_limit)]
            );
        } else {
            $this::addItem('discount', $coupon->discount);
            $couponData = [
                'code' => $coupon->code,
                'discount' => $coupon->discount,
                'amount' => number_format($totalOrderAmount - $coupon->discount + $transportFee)
            ];
            return $this->response(200, 'OK', $couponData);
        }

        return $this->response(404, 'NG', $responseData);
    }

    public function destroyDiscount()
    {
       $this::deleteItem('discount');

        return $this->response(200, 'OK', []);
    }
}
