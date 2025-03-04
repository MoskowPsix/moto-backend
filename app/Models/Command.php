<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 */

class Command extends Model
{
    use HasFactory;

    protected $table = 'commands';
    protected $fillable = [
        'name',
        'avatar',
        'city',
        'user_id',
        'location_id',
        'fullName',
        'coach',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function coaches(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_command_coach', 'command_id', 'user_id');
    }
}
