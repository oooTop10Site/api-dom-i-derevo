<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceToOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'option_id',
    ];
}
