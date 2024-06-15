<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'discount',
        'limit_number',
        'number_used',
        'expiration_date',
        'payment_limit',
        'description',
        'created_by'
    ];

    public function getCreatedAtAttribute()
    {
        return date('Y/m/d', $this->created_at);
    }
}
