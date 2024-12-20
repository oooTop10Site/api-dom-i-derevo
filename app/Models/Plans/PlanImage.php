<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'image_id'
    ];

    // Добавляем связь с моделью Image
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
