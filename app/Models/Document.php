<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'type',
        'path',
        'data',
        'user_id',
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'path' => 'string',
        'data' => 'json',
    ];
}
