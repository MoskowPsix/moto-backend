<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static find(int $id)
 */
class Phone extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'last_num',
        'user_id',
        'number_verified_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function p_code(): HasOne
    {
        return $this->hasOne(PCode::class);
    }
}
