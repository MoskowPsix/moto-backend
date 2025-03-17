<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
//use MoonShine\UI\Fields\Phone;

/**
 * @extends ModelResource<Phone>
 */
class PhoneResource extends ModelResource
{
    protected string $model = Phone::class;

    protected string $title = 'Телефоны';

//    protected string $column = 'number';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Phone::make('Номер', 'number')->sortable(),
            Date::make('Подтверждение телефона', 'number_verified_at')->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Phone::make('Номер', 'number'),
                Date::make('Подтверждение телефона', 'number_verified_at'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param Phone $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
