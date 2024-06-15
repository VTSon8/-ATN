<?php

namespace App\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    const DEFAULT_SALE = 8;
    const DEFAULT_RELATA = 4;
    const DEFAULT_SELLING = 5;
    public function getAllProduct($key_word = null)
    {
        return $this->model->query()->when($key_word, function ($query) use ($key_word) {
            $query->where('name', 'like', '%'.$key_word.'%')
                ->orWhere('description', 'like', '%'.$key_word.'%')
                ->orWhere('selling_price', 'like', '%'.$key_word.'%');
        })
            ->with('category:id,name')
            ->paginate(config('constants.pagination'));
    }

    public function getfeaturedBooks() {
        return $this->model->orderBy('sale', 'DESC')->limit(self::DEFAULT_SALE)->get();
    }

    public function getSellingBooks() {
        return $this->model->orderBy('number_buy', 'desc')->limit(self::DEFAULT_SELLING)->get();
    }

    public function getProductByCondition($key_word, $sortBy)
    {
        return $this->model->when($key_word, function ($query) use ($key_word) {
            $query->where('name', 'like', "%$key_word%")
            ->orWhere('author', 'like', "%$key_word%");
        })->orderBy($sortBy['column'], $sortBy['sort'])
            ->paginate(config('constants.PER_PAGE'));
    }

    public function createProduct(array $params)
    {
        return $this->model->create($params);
    }

    public function getProductById($id)
    {
        return $this->model->with('category:id,name', 'images')->whereId($id)->first();
    }

    public function updateProduct($id, array $params)
    {
        return $this->model->find($id)->update($params);
    }

    public function deleteProduct($id)
    {
        return $this->model->destroy($id);
    }

    public function restoreProductById($id)
    {
        return $this->model->withTrashed()->whereId($id)->restore();
    }

    public function foreverDeleteProductById($id)
    {
        return $this->model->withTrashed()->find($id)->forceDelete();
    }

    public function totalTrash()
    {
        return $this->model->onlyTrashed()->count();
    }

    public function searchProduct($key_word)
    {
        $products = $this->model->select(['id', 'name'])->orderBy('id', 'DESC');
        if (!empty($key_word)) {
            $products = $this->model->query()->where(function ($query) use ($key_word) {
                $query->where('name', 'like', '%'.$key_word.'%')
                    ->orWhere('description', 'like', '%'.$key_word.'%')
                    ->orWhere('selling_price', 'like', '%'.$key_word.'%');
            })->orderBy('id', 'ASC');
        }

        return $products->paginate(config('constants.PER_PAGE'));
    }

    public function findProduct($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getAllSimilarProducts($id, $category_id)
    {
        return $this->model->where('id', '<>', $id)
            ->where('category_id', $category_id)
            ->limit(self::DEFAULT_RELATA)
            ->get();
    }

    public function getProductBySlug($slug)
    {
        return $this->model->where('slug', $slug)->with('category:id,name', 'images:id,product_id,name')->firstOrFail();
    }

    public function getPromotionalProducts()
    {
        return $this->model->where('sale', '>', 0)->latest('sale')->limit(config('common.promotional_limit'))->get();
    }

    public function getProductByCategory($slug)
    {
        return $this->model->whereHas('category', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->paginate(config('constants.PER_PAGE'));
    }

    public function getAuthorAll()
    {
        return $this->model->distinct()->pluck('author');
    }

    public function getProductByIdOnlyTrashed($id)
    {
        return $this->model->onlyTrashed()->whereId($id)->first();
    }

    public function getOnlyTrashed()
    {
        return $this->model->onlyTrashed()->with('account:id,name')->paginate(config('constants.pagination'));
    }

    public function updateProductStatus($id, int $status)
    {
        $product_status['status'] = ($status == $this->model::PUBLISHED) ? $this->model::NOT_PUBLISHED : $this->model::PUBLISHED;

        return $this->model->whereId($id)->update($product_status);
    }

    public function getModel()
    {
        return Product::class;
    }
}
