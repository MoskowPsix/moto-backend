<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Degree extends Model
{
    /** @use HasFactory<\Database\Factories\DegreeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
    ];

    public function cups(): HasMany
    {
        return $this->hasMany(Cup::class);
    }
}
