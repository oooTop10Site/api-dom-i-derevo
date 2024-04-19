<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'image',
        'sort_order',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'url_image'
    ];

    public function getUrlImageAttribute() {
        return env('APP_URL') . Storage::url($this->image);
    }

    public function articles() {
        return $this->hasMany(Article::class, 'category_id');
    }
}
