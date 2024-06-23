<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Services\CartService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoogleMapController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function shippingCost(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $totalOrderAmount = $this->cartService->getTotalOrderAmount();
            $discount = $this::getItem('discount') ?? 0;
            $config = Config::firstOrFail();
            $kmPrices = $config->km_prices;
            $kilometers = $this->calculateDistance(
                (float)$config['latitude'],
                (float)$config['longitude'],
                (float)$request->lat_from,
                (float)$request->long_from
            );

            if ($kilometers > 2000) {
                return $this->response(404, 'NG', []);
            }

            $priceShip = $this->calculateShippingRate($kilometers, $kmPrices);
            $amount = $totalOrderAmount + $priceShip - $discount;
            $this::addItem('transport_fee', $priceShip);
            return $this->response(
                200,
                'OK',
                ['price_ship' => number_format($priceShip), 'km' => $kilometers, 'amount' => number_format($amount)]
            );
        } catch (\Exception $e) {
            return $this->response(404, 'NG', []);
        }
    }


    protected function calculateShippingRate($distance, $priceArray)
    {
        $shippingRate = 0;

        usort($priceArray, function ($a, $b) {
            return $b['km'] - $a['km'];
        });

        foreach ($priceArray as $priceInfo) {
            if ($distance >= $priceInfo['km']) {
                $shippingRate = $priceInfo['price_ship'];
                break;
            }
        }

        return $shippingRate;
    }

    protected function calculateDistance($lat1, $long1, $lat2, $long2)
    {
        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(
                    deg2rad($theta)
                ));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $result['miles'] = $miles * 60 * 1.1515;
        $result['kilometers'] = $result['miles'] * 1.609344;
        return $result['kilometers'];
    }

    public function destroyFee()
    {
        $this::deleteItem('transport_fee');

        return $this->response(200, 'OK', []);
    }
}
