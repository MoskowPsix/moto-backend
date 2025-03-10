<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Store extends Model
{
    protected $fillable = [
        'login',
        'password_1',
        'password_2',
        'token',
        'user_id',
    ];
//    protected $hidden = [
//        'login',
//        'password_1',
//        'password_2',
//        'token',
//    ];
    protected $casts = [
        'login' => 'encrypted',
        'password_1' => 'encrypted',
        'password_2' => 'encrypted',
        'token' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
