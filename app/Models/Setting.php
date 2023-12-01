<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'code',
        'value',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
