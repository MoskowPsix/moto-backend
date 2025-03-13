<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $pin
 */
class PCode extends Model
{
    protected $fillable = [
        'pin',
        'key',
        'is_used',
    ];

    public function phone(): BelongsTo
    {
        return $this->belongsTo(Phone::class);
    }
}
