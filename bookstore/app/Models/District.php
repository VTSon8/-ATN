<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'id',
        'province_id',
        'name',
        'prefix',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
