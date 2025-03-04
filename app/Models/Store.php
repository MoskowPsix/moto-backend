<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'login',
        'password_1',
        'password_2',
        'token',
    ];
    protected $hidden = [
        'login',
        'password_1',
        'password_2',
        'token',
    ];
    protected $casts = [
        'login' => 'encrypted',
        'password_1' => 'encrypted',
        'password_2' => 'encrypted',
        'token' => 'encrypted',
    ];

}
