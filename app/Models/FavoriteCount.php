<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteCount extends Model
{
    protected $fillable = [
      'count',
      'race_id'
    ];

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
}
