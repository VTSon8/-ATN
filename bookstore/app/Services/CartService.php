<?php
namespace App\Services;

use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
                    'options' => ['image' => $product->thumb, 'slug' => $product->slug, 'sale' => $product->sale]
                ]);
            }else{
                Cart::update($book->rowId, ['qty' => $qty + (int)$book->qty]);
            }

            return true;
        }catch (\Exception $e) {
            return false;
        }
    }


}
