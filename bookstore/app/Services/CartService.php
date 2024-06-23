<?php
namespace App\Services;

use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CartService {

    private $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }

    public function handleAddToCart(int $id, int $qty = 1): bool
    {
        try {
            $product = $this->productRepository->findProduct($id);
            $cart = Cart::content() ?? collect();
            $book = $cart->first(function ($item) use ($product) {
                return $product->id === $item->id;
            });

            if (is_null($book)) {
                Cart::add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->selling_price ?? $product->original_price,
                    'qty' => $qty,
                    'weight' => 0,
                    'options' => ['image' => $product->thumb, 'slug' => $product->slug, 'sale' => $product->sale, 'number' => $product->number]
                ]);
            }else{
                Cart::update($book->rowId, ['qty' => $qty + (int)$book->qty]);
            }

            return true;
        }catch (\Exception $e) {
            return false;
        }
    }

    public function getData()
    {
        $cart = Cart::content() ?? [];
        $dataList = [];
        $recalculateProductuantity = [];
        $totalMoney = 0;
        foreach ($cart as $index => $book) {
            $intoMoney = (int)data_get($book, 'price') * data_get($book, 'qty');
            $totalMoney += $intoMoney;
            $dataList[] = [
                'product_id' => (int)data_get($book, 'id'),
                'quantity' => (int)data_get($book, 'qty'),
                'price' => (int)data_get($book, 'price'),
//                'into_money' => number_format($intoMoney),
            ];
            $recalculateProductuantity[] = [data_get($book, 'id') => (int)data_get($book, 'options.number') - (int)data_get($book, 'qty')];
        }

        return ['data' => $dataList, 'total_money' => $totalMoney, 'recalculate_product_quantity' => $recalculateProductuantity];
    }

    public function getTotalOrderAmount()
    {
        $cart = Cart::content() ?? [];
        $totalMoney = 0;
        foreach ($cart as  $book) {
            $intoMoney = (int)data_get($book, 'price') * (int)data_get($book, 'qty');
            $totalMoney += $intoMoney;
        }

        return $totalMoney;
    }

    public function flashCart() {
        Cart::destroy();
    }


}
