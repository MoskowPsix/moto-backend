<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Traits\MoonShine\Resources\RaceResourceTrait;
use App\Traits\MoonShine\Resources\RaceResultsResourceTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\RaceResult;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;

/**
 * @extends ModelResource<RaceResult>
 */
class RaceResultsResource extends ModelResource
{
    protected string $model = RaceResult::class;

    protected string $title = 'Результаты гонки';
    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;
    protected int $itemsPerPage = 5;
    use RaceResultsResourceTrait;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Number::make('Личные очки', 'scores'),
            Number::make('Место', 'place'),
            $this->user(),
            $this->command(),
            $this->cup(),
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
     * @param RaceResults $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
