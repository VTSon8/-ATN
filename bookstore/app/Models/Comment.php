<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'content',
        'product_id',
        'customer_id',
        'comment_id',
    ];

    public function children() {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function getRemainingDaysAttribute()
    {
        $createdAt = Carbon::parse($this->created_at);
        return $createdAt->diffForHumans();
    }

}
