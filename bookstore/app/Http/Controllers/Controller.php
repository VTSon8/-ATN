<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param  int  $code
     * @param  string  $msg
     * @param  array  $items
     * @return JsonResponse
     */
    protected function response(int $code = 200, string $msg = '', array $items = []): JsonResponse
    {
        $json = [
            'code' => $code,
            'msg' => $msg,
            'date' => time(),
            'items' => [],
        ];
        if ($items) {
            foreach ($items as $key => $item) {
                $json['items'][$key] = $item;
                switch ($key) {
                    case 'created_at':
                    case 'updated_at':
                        if (is_object($json['items'][$key])) {
                            $json['items'][$key] = (string)$json['items'][$key];
                        }
                        break;
                }
            }
        }
        return response()->json($json);
    }

    public static function addItem(string $key, $value)
    {
        Session::put($key, $value);
    }

    public static function getItem(string $key)
    {
        return Session::get($key);
    }

    public static function deleteItem(string $key)
    {
        return Session::remove($key);
    }
}
