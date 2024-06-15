<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = ['id', 'web_information', 'name', 'longitude', 'latitude', 'km_prices'];

    protected $casts = [
        'km_prices' => 'json',
    ];
}
