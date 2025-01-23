<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 */
class Race extends Model
{
    use HasFactory;
    protected $table = 'races';
    protected $fillable = [
        'name',
        'desc',
        'is_work',
        'date_start',
        'images',
        'track_id',
        'user_id',
    ];
    protected $casts = [
        'name' => 'string',
        'desc' => 'string',
        'images' => 'json',
        'is_work' => 'boolean',
        'date_start' => 'datetime',
    ];

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class)->selectRaw('*, ST_AsGeoJSON(point) as point');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'appointment_races', 'race_id', 'user_id');
    }
    public function appointmentCount(): HasOne
    {
        return $this->hasOne(AppointmentRaceCount::class);
    }
}
