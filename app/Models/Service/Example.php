<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $table = 'service_examples';

    protected $fillable = [
        'name',
        'image',
        'sort_order',
        'status',
    ];

    protected $hidden = [
        'id',
        'sort_order',
        'status',
    ];

    public function services() {
        return $this->belongsToMany(Service::class, 'service_to_example', 'example_id', 'service_id');
    }

    public function relationship_service() {
        return $this->hasMany(ServiceToExample::class, 'example_id');
    }
}
