<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
    ];

    public function plans(){
        return $this->belongsToMany(Plan::class, 'plan_images');
    }
}
