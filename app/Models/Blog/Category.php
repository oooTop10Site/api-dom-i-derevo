<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'blog_categories';

    protected $fillable = [
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
    ];

    protected $hidden = [
        'id',
        'sort_order',
        'status',
        'created_at',
        'updated_at',
    ];

    public function articles() {
        return $this->hasMany(Article::class, 'category_id');
    }
}
