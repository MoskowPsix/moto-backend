<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static where(string $string, $id)
 * @method static whereHas(string $string, \Closure $param)
 */

class Command extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'commands';
    protected $fillable = [
        'name',
        'avatar',
        'city',
        'user_id',
        'location_id',
        'full_name',
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
        return $this->belongsToMany(User::class, 'command_coach', 'command_id', 'user_id');
    }
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_command_member', 'command_id', 'user_id');
    }
}
