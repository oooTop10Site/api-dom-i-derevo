<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Authenticatable;

    protected $table = 'users';

    protected $fillable = [
        'login',
        'password',
        'name',
        'status',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed'
    ];
}
