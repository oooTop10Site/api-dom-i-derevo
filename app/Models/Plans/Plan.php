<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'floor_title',
        'square'
    ];

    public function images(){
        return $this->belongsToMany(Image::class, 'plan_images');
    }
}
