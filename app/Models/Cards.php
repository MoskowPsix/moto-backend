<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Cards extends Model
{
    use HasFactory;
    protected $fillable = [
        'op_key',
        'user_id',
    ];
    protected $casts = [
        'op_key' => 'encrypted',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
