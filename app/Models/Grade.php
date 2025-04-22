<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 */
class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'grade_id'
    ];

    public function gradeParent(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id', 'grades');
    }
    public function gradeChild(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
