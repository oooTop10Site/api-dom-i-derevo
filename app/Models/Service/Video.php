<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    public function services(){
        return $this->belongsToMany(Service::class, 'service_videos');
    }
}
