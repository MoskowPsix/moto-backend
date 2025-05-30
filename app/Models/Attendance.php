<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static where(string $string, int $trackId)
 * @method static findOrFail(int $attendanceId)
 */
class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'price',
        'tax',
        'usn_income_outcome',
        'track_id',
        'race_id'
    ];

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'attendance_transaction', 'attendance_id', 'transaction_id');
    }
}
