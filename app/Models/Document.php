<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create()
 */
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
        'data' => 'encrypted',
    ];

}
