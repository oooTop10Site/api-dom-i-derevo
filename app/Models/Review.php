<?php

namespace App\Models;

use App\Models\Service\Category;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'author',
        'text',
        'sort_order',
        'status',
        'date_available',
    ];

    protected $hidden = [
        'id',
        'sort_order',
        'status',
        'created_at',
        'updated_at',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
