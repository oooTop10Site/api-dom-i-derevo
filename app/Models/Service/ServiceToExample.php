<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class ServiceToExample extends Model
{
    protected $table = 'service_to_example';

    protected $fillable = [
        'service_id',
        'example_id',
    ];

    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function example() {
        return $this->belongsTo(Example::class, 'example_id');
    }
}
