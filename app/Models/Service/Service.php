<?php

namespace App\Models\Service;

use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
        'price',
        'description',
        'preview',
        'additional_info',
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

    public function categories() {
        return $this->belongsToMany(Category::class, 'service_to_category', 'service_id', 'category_id');
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'service_to_service', 'service_id', 'additional_service_id');
    }

    public function service() {
        return $this->belongsToMany(Service::class, 'service_to_service', 'additional_service_id', 'service_id');
    }

    public function relationship_category() {
        return $this->hasMany(ServiceToCategory::class, 'service_id');
    }

    public function relationship_service() {
        return $this->hasMany(ServiceToService::class, 'service_id');
    }

    public function relationship_additional_service() {
        return $this->hasMany(ServiceToService::class, 'additional_service_id');
    }

    public function relationship_image() {
        return $this->hasMany(ServiceImage::class, 'service_id');
    }

    public function images() {
        return $this->hasMany(ServiceImage::class, 'service_id');
    }

    public function options(){
        return $this->belongsToMany(Option::class, 'service_to_options');
    }

    public function videos() {
        return $this->belongsToMany(Video::class, 'service_videos');
    }


}
