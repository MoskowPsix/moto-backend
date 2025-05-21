<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;


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
            \MoonShine\UI\Fields\Phone::make('Номер', 'number')->sortable(),
            BelongsTo::make('Пользователь', 'user', resource: UserResource::class),
            Date::make('Подтверждение телефона', 'number_verified_at')->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            ID::make(),
            \MoonShine\UI\Fields\Phone::make('Номер', 'number'),
            BelongsTo::make('Пользователь', 'user', resource: UserResource::class)->searchable(),
            Date::make('Подтверждение телефона', 'number_verified_at'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            \MoonShine\UI\Fields\Phone::make('Номер', 'number'),
            BelongsTo::make('Пользователь', 'user', resource: UserResource::class),
            Date::make('Подтверждение телефона', 'number_verified_at'),
        ];
    }

    protected function beforeCreating(mixed $item): mixed
    {
        if(request()->has('user_id')) {
            $item->user_id = request('user_id');
        }
        return $item;
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
    protected function search(): array
    {
        return [
            'number',
        ];
    }
    protected function filters(): iterable
    {
        return [
            Number::make('ID', 'id'),
            Text::make('Номер', 'number'),
        ];
    }
}
