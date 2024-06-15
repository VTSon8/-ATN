<?php

namespace App\Models;

//use App\Traits\AuthorObservable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;
//    use AuthorObservable;

    protected $fillable = [
        'name',
        'thumb',
        'description',
        'created_by',
        'updated_by',
        'status'
    ];
}
