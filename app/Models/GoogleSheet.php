<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleSheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'spread_sheet_id',
        'url',
        'race_id'
    ];

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
}
