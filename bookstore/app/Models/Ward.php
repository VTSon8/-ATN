<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'wards';

    protected $fillable = [
        'id',
        'district_id',
        'name',
        'prefix',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
