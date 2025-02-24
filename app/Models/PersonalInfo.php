<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static findOrFail(int $id)
 */
class PersonalInfo extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',             // Имя
        'surname',          // Фамилия
        'patronymic',       // Отчество
        'date_of_birth',    // Дата рождения
        'city',             // Город
        'inn',              // ИНН
        'snils',            // СНИЛС
        'phone_number',     // Номер телефона
        'start_number',     // Стартовый номер
        'group',            // Группа гонки
        'rank_number',      // Номер удостеверения МСМК, МС, КМС
        'rank',             // Звание или разряд
        'community',        // Команда
        'coach',            // Тренер
        'moto_stamp',       // Марка мотоцикла
        'engine',           // двигатель
        'user_id',
        'number_and_seria',   // Серия и номер паспорта
        'region',               // Область в текстовом формате(Оставлена, чтоб не вызывать ошибок)
        'location_id',          // id области из таблицы locations
    ];

    protected $casts = [
        'name'              => 'string', // Убрано шифрование
        'surname'           => 'string',
        'patronymic'        => 'string', // Убрано шифрование
        'date_of_birth'     => 'string',
        'gender'            => 'string',
        'city'              => 'string',
        'inn'               => 'encrypted',
        'snils'             => 'encrypted',
        'phone_number'      => 'string', // Убрано шифрование
        'start_number'      => 'string',
        'group'             => 'string',
        'rank_number'       => 'string', // Убрано шифрование
        'rank'              => 'string',
        'community'         => 'string',
        'coach'             => 'string',
        'moto_stamp'        => 'string',
        'engine'            => 'string',
        'number_and_seria'  => 'encrypted',
        'region'            => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
