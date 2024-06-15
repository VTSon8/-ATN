<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    const DEFAULT_PER_PAGE = 5;
    public function getAllCategory()
    {
        return $this->model->with('parent:id,name')
            ->withCount('products')
            ->paginate(config('constants.pagination'));
    }

    public function getAll()
    {
        return $this->model->with('parent:id,name')->get();
    }

    public function getCategoryBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function createCategory(array $params)
    {
        return $this->model->create($params);
    }

    public function getCategoryById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function updateCategory($id, array $params)
    {
        return $this->model->whereId($id)->update($params);
    }

    public function getSubCategory()
    {
        return $this->model->whereNotNull('parent_id')->get();
    }

    public function getParentCategory()
    {
        return $this->model->whereNull('parent_id')->get();
    }

    public function getBooksByCategory() {
        return $this->model->with('products')->limit(self::DEFAULT_PER_PAGE)->orderByRaw('ISNULL(no), no ASC')->get();
    }

    public function getModel()
    {
        return Category::class;
    }
}
