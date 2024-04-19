<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'image',
        'category_id',
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

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
