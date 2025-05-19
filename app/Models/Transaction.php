<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $array)
 * @method static findOrFail(int $id)
 * @method static find(mixed $invId)
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'desc',
        'count',
        'user_id',
        'date',
        'attendance_id',
        'data'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function attendances(): BelongsToMany
    {
        return $this->belongsToMany(Attendance::class, 'attendance_transaction', 'transaction_id', 'attendance_id');
    }
}
