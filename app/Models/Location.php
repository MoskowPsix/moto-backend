<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',                 // Название гео объекта
        'address',              // Адрес до гео объекта
        'point',                // Координаты объекта
        'population',           // Население
        'type',                 // Тип объекта (город или посёлок, район, область или край)
        'postal_code',          // Как понял индекс
        'time_zone',            // Часовой пояс
        'integration_data',     // Вся информация полученная во время интеграции
        'location_id',          // Объект ссылается сам на себя, для реализации иерархии в рамках одной таблицы
        'district_id',
    ];

    protected array $postgisColumns = [
        'point' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];
    protected $casts = [
        'name'              => 'string',
        'integration_data'  => 'json',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
