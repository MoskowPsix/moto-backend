<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 */
class Track extends Model
{
    use HasFactory; // Searchable;
    protected $fillable = [
        'name',
        'address',
        'point',
        'images',
        'level_id',
        'desc',
        'length',
        'turns',
        'free',
        'is_work',
        'spec',
        'user_id',
        'contacts',
        'location_id',
        'logo',
        'light',
        'season',
        'schema_img',
        'attendance_id',
        'store_id',
    ];

    protected $casts =[
        'name'          => 'string',
        'level_id'      => 'integer',
        'address'       => 'string',
        'desc'          => 'string',
        'length'        => 'integer',
        'turns'         => 'integer',
        'free'          => 'boolean',
        'is_work'       => 'boolean',
        'spec'          => 'json',
        'images'        => 'json',
        'contacts'      => 'json',
    ];
    protected array $postgisColumns = [
        'point' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
