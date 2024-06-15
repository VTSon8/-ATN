<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'representative_name',
        'email',
        'phone',
        'address',
        'status',
        'created_by',
        'updated_by'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'created_by');
    }

}
