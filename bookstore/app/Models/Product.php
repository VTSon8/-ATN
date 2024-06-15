<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'slug',
        'thumb',
        'source_url',
        'description',
        'detail',
        'supplier_id',
        'number',
        'number_buy',
        'sale',
        'original_price',
        'selling_price',
        'avg_rate',
        'status',
        'author',
        'lang',
        'translator',
        'imprint',
        'publishing_year',
        'weight',
        'size',
        'number_of_pages',
        'form',
        'created_at',
        'created_by',
        'updated_by',
    ];

    const NOT_PUBLISHED = 0;
    const PUBLISHED = 1;

    public function scopeSort($query, $column, $sort)
    {
        return $query->orderBy($column, $sort);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id')->latest('id');
    }

    public function ratings()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
