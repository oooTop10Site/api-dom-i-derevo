<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class ServiceToCategory extends Model
{
    protected $table = 'service_to_category';

    protected $fillable = [
        'service_id',
        'category_id',
    ];

    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
