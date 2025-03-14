<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 */
class Cup extends Model
{
    protected $fillable = [
        'name',
        'year',
        'region',
        'location_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function race(): BelongsToMany
    {
        return $this->belongsToMany(Race::class, 'race_cup', 'cup_id', 'race_id');
    }
}
