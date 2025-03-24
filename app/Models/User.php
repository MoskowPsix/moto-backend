<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $name)
 * @method static whereIn(string $string, array $usersIds)
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function personalInfo(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PersonalInfo::class);
    }
    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Document::class);
    }
    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Race::class, 'appointment_races', 'race_id', 'user_id');
    }
    public function ecode(): HasOne
    {
        return $this->hasOne(ECode::class);
    }
//    public function commissions(): BelongsToMany
//    {
//        return $this->belongsToMany(User::class, 'race_commission', 'race_id', 'user_id');
//    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class);
    }
    public function favoritesUser(): BelongsToMany
    {
        return $this->belongsToMany(Race::class, 'favorite_races', 'user_id', 'race_id');
    }
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Command::class, 'user_command_member', 'user_id', 'command_id');
    }
}
