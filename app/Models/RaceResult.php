<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaceResult extends Model
{
    protected $fillable = [
        'user_id',
        'race_id',
        'cup_id',
        'command_id',
        'scores',
        'place',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
    public function command(): BelongsTo
    {
        return $this->belongsTo(Command::class);
    }
    public function cup(): BelongsTo
    {
        return $this->belongsTo(Cup::class);
    }
}
