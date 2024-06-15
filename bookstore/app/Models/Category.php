<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'image_url',
        'no',
        'slug',
        'description',
        'created_by',
        'status',
    ];

    public function getCountParentIdAttribute()
    {
        $countParentId = Category::query()->whereParentId($this->id)->count();
        return $countParentId;
    }

    public function getPosterAttribute()
    {
        $poster = Account::query()->findOrFail($this->updated_by)->toArray();
        return $poster['name'];
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parentProducts()
    {
        return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id')
            ->distinct();
    }

    public function productsRecursive($key_word, $sortBy)
    {
        $categoryIds = $this->children->pluck('id') ?? $this->id;

        return Product::when($key_word, function ($query) use ($key_word) {
            $query->where('name', 'like', "%$key_word%");
        })->whereIn('category_id', $categoryIds)
            ->orWhere('category_id', $this->id)
            ->orderBy($sortBy['column'], $sortBy['sort']);
    }


}
