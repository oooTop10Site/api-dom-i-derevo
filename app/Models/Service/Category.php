<?php

namespace App\Models\Service;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $table = 'service_categories';

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

    public function categories() {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'service_to_category', 'category_id', 'service_id');
    }

    public function relationship_service() {
        return $this->hasMany(ServiceToCategory::class, 'category_id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'category_id');
    }
}
