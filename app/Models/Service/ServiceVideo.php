<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'video_id'
    ];
}
