<?php

namespace App\Models;

use App\Traits\Models\FavoriteUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class FavoriteUser extends Model
{
    protected $fillable = [
        'user_id',
        'race_id'
    ];

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
