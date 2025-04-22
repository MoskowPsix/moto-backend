<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Grade>
 */
class GradeResource extends ModelResource
{
    protected string $model = Grade::class;

    protected string $title = 'Классы';

    protected string $column = 'name';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('name')->sortable(),
            Text::make('description')->sortable(),
            BelongsTo::make('Автор', 'user', resource: \App\MoonShine\Resources\UserResource::class)->searchable(),
            BelongsTo::make('Родитель', 'gradeParent', resource: \App\MoonShine\Resources\GradeResource::class)->searchable()->nullable(),
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
                Text::make('name')->sortable(),
                Text::make('description')->sortable(),
                BelongsTo::make('Автор', 'user', resource: \App\MoonShine\Resources\UserResource::class)->searchable(),
                BelongsTo::make('Родитель', 'gradeParent', resource: \App\MoonShine\Resources\GradeResource::class)->searchable()->nullable(),
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
            Text::make('name')->sortable(),
            Text::make('description')->sortable(),
            BelongsTo::make('Автор', 'user', resource: \App\MoonShine\Resources\UserResource::class)->searchable(),
            BelongsTo::make('Родитель', 'gradeParent', resource: \App\MoonShine\Resources\GradeResource::class)->searchable()->nullable(),
        ];
    }

    /**
     * @param Grade $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
