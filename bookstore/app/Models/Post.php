<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'img',
        'created_by',
        'updated_by',
        'status'
    ];

    const NOT_PUBLISHED = 0;
    const PUBLISHED = 1;


}
