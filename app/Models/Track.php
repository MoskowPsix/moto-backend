<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory; // Searchable;
    protected $fillable = [
        'name',
        'address',
        'point',
        'images',
    ];

    protected $casts =[
        'images' => 'json',
    ];
    protected array $postgisColumns = [
        'point' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];
}
