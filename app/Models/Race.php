<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 */
class Race extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'races';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'desc',
        'is_work',
        'date_start',
        'images',
        'position_file',
        'results_file',
        'pdf_files',
        'record_start',
        'record_end',
        'track_id',
        'user_id',
        'location_id',
        'status_id',
        'store_id'
    ];
    protected $casts = [
        'name' => 'string',
        'desc' => 'string',
        'images' => 'json',
        'pdf_files' => 'json',
        'is_work' => 'boolean',
        'date_start' => 'datetime',
    ];

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class)->selectRaw('*, ' . (config('database.default') === 'sqlite' ? 'point' : 'ST_AsGeoJSON(point) as point'));
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
    public function sheet(): HasOne
    {
        return $this->hasOne(GoogleSheet::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function grades():BelongsToMany
    {
        return $this->belongsToMany(Grade::class)->orderBy('name', 'asc');
    }
    public function commissions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'race_commission', 'race_id', 'user_id');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function cups(): BelongsToMany
    {
        return $this->belongsToMany(Cup::class, 'race_cup', 'race_id', 'cup_id');
    }
    public function favouritesUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_users', 'race_id', 'user_id');
    }
    public function favoritesCount(): HasOne
    {
        return $this->hasOne(FavoriteCount::class);
    }
    public function results(): HasMany
    {
        return $this->HasMany(RaceResult::class);
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
