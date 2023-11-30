<?php

namespace App\Models;

use App\Models\Service\Category;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'author',
        'category_id',
        'text',
        'sort_order',
        'status',
        'date_available',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
