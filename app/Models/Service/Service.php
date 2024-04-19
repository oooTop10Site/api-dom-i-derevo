<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

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
        'sort_order',
        'status',
        'created_at',
        'updated_at',
    ];

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
}
