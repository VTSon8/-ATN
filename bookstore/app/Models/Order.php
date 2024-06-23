<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'code',
        'customer_id',
        'name',
        'phone',
        'amount',
        'fee',
        'discount',
        'payment_type',
        'payment_status',
        'address',
        'status'
    ];

    const PENDING = 0;
    const PREPARE = 1;
    const DELIVERING = 2;
    const DELIVERED = 3;
    const CUSTOMER_CANCEL = 4;
    const STAFF_CANCEL = 5;
    const PAID = 1;
    const UNPAID = 0;

    public function scopePending($query)
    {
        $query->where('status', Order::PENDING)->orderBy('created_at', 'DESC');
    }

    public function scopeProcess($query)
    {
        $query->where('status', '<>', Order::PENDING)->orderBy('created_at', 'DESC');
    }

    public function getOrderStatusAttribute()
    {
        switch ($this->status) {
            case(Order::PENDING):
                return trans('common.order_status.pending');
                break;
            case(Order::PREPARE):
                return trans('common.order_status.prepare');
                break;
            case(Order::DELIVERING):
                return trans('common.order_status.delivering');
                break;
            case(Order::DELIVERED):
                return trans('common.order_status.delivered');
                break;
            case(Order::CUSTOMER_CANCEL):
                return trans('common.order_status.customer_cancel');
                break;
            case(Order::STAFF_CANCEL):
                return trans('common.order_status.staff_cancel');
                break;
            default:
                return 'WRONG';
        }
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot(['quantity', 'price']);
    }

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }


}
