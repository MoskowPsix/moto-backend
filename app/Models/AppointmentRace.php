<?php

namespace App\Models;

use App\Traits\Models\AppointmentRaceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $array)
 */
class AppointmentRace extends Model
{
    use AppointmentRaceTrait, HasFactory;

    protected $fillable = [
        'race_id',
        'user_id',
        'data',
        'surname',
        'name',
        'patronymic',
        'engine',
        'start_number',
        'licenses_number',
        'rank',
        'date_of_birth',
        'community',
        'moto_stamp',
        'number_and_seria',
        'snils',
        'phone_number',
        'polis_number',
        'coach',
        'inn',
        'city',
        'location_id',
        'grade_id',
        'command_id',
        'comment',
        'commission_id',
        'is_checked',
        'transaction_id'
    ];

    protected $casts = [
        'data'              => 'encrypted',
        'number_and_seria'  => 'encrypted',
        'snils'             => 'encrypted',
        'inn'               => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class);
    }
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    public function command(): BelongsTo
    {
        return $this->belongsTo(Command::class);
    }
    public function commission(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commission_id', 'id', 'users');
    }
    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
