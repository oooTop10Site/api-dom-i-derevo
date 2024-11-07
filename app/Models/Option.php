<?php

namespace App\Models;

use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment',
        'floor_quantity',
        'floor_text',
        'description',
    ];

    public function services(){
        return $this->belongsToMany(Service::class, 'service_to_options');
    }
}
