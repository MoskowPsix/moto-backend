<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Attendance>
 */
class AttendanceResource extends ModelResource
{
    protected string $model = Attendance::class;

    protected string $title = 'Услуги';
    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;
    protected string $column = 'name';
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Название', 'name'),
            Number::make('Цена', 'price')->sortable()->min(0)->step(0.01),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Text::make('Название', 'name'),
            Number::make('Цена', 'price')->sortable()->min(0)->step(0.01),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('Название', 'name'),
            Number::make('Цена', 'price')->sortable()->min(0)->step(0.01),
        ];
    }

    /**
     * @param Attendance $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            Text::make('Название', 'name'),
            Number::make('Цена', 'price')->sortable()->min(0)->step(0.01),
        ];
    }
}
