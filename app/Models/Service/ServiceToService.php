<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class ServiceToService extends Model
{
    protected $table = 'service_to_service';

    protected $fillable = [
        'service_id',
        'additional_service_id',
    ];

    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function additional_service() {
        return $this->belongsTo(Service::class, 'additional_service_id');
    }
}
