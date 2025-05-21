<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
/**
 * @extends ModelResource<Location>
 */
class LocationResource extends ModelResource
{
    protected string $model = Location::class;

    protected string $title = 'Локации';
    protected string $column = 'name';
    protected bool $simplePaginate = true;
    protected bool $columnSelection = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('name')->sortable(),
            BelongsTo::make('Округ', 'district', resource: DistrictResource::class)
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('name')->sortable(),
                BelongsTo::make('Округ', 'district', resource: DistrictResource::class)->searchable()->nullable()->columnSelection(),
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
            Text::make('name')->sortable(),
            BelongsTo::make('Округ', 'district', resource: DistrictResource::class)->searchable()->nullable()->columnSelection()
        ];
    }

    /**
     * @param Location $item
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
