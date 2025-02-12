<?php

namespace App\Models;

use App\Traits\Models\AppointmentRaceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $array)
 */
class AppointmentRace extends Model
{
    use AppointmentRaceTrait, HasFactory;

    protected $fillable = [
        'race_id',
        'user_id',
        'data',
    ];

    protected $casts = [
        'data'              => 'encrypted',
    ];
}
