<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'blog_articles';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'preview',
        'image',
        'sort_order',
        'status',
        'meta_title',
        'meta_h1',
        'meta_description',
        'meta_keywords',
        'seo_keyword',
        'date_available',
    ];

    protected $hidden = [
        'id',
        'category_id',
        'category_id',
        'sort_order',
        'status',
        'created_at',
        'updated_at',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
