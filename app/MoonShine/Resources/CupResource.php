<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cup;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Cup>
 */
class CupResource extends ModelResource
{
    protected string $model = Cup::class;

    protected string $title = 'Кубки';
    protected string $column = 'name';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name')->sortable(),
            Number::make('Год', 'year')->sortable(),
            BelongsTo::make('Локация', 'location', LocationResource::class),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make()->sortable(),
                Text::make('Имя', 'name')->required(),
                Number::make('Год', 'year')->required(),
                Color::make('Цвет', 'color'),
                BelongsTo::make('Локация', 'location', resource: LocationResource::class)->searchable()->nullable(),
                BelongsTo::make('Автор', 'user', resource: UserResource::class)->searchable(),
                BelongsTo::make('Уровень', 'degree', resource: DegreeResource::class)->searchable()->nullable(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name')->required(),
            Number::make('Год', 'year')->required(),
            Color::make('Цвет', 'color'),
            BelongsTo::make('Локация', 'location', resource: LocationResource::class)->searchable()->nullable(),
            BelongsTo::make('Автор', 'user', resource: UserResource::class)->searchable(),
            BelongsTo::make('Уровень', 'degree', resource: DegreeResource::class)->searchable()->nullable(),
        ];
    }

    /**
     * @param Cup $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
    protected function filters(): iterable
    {
        return [
            Number::make('ID', 'id'),
            Text::make('Название', 'name'),
        ];
    }
}
