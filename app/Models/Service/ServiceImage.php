<?php

namespace App\Models\Service;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    protected $table = 'service_images';

    protected $fillable = [
        'service_id',
        'image',
        'sort_order',
    ];

    protected $hidden = [
        'id',
        'service_id',
        'image',
        'sort_order',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'url_image'
    ];

    public function getUrlImageAttribute() {
        return env('APP_URL') . Storage::url($this->image);
    }

    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
