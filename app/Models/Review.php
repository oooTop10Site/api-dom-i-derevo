<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'author',
        'role',
        'text',
        'reply',
        'rating',
        'sort_order',
        'status',
        'date_available',
    ];
}
