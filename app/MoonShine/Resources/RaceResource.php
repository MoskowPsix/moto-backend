<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Race;
use App\MoonShine\Pages\Race\RaceIndexPage;
use App\MoonShine\Pages\Race\RaceFormPage;
use App\MoonShine\Pages\Race\RaceDetailPage;

use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Table\TableBuilder;

/**
 * @extends ModelResource<Race, RaceIndexPage, RaceFormPage, RaceDetailPage>
 */
class RaceResource extends ModelResource
{
    protected string $model = Race::class;
    protected bool $simplePaginate = true;
    protected string $title = 'Гонки';
    protected string $column = 'name';

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [
            RaceIndexPage::class,
            RaceFormPage::class,
            RaceDetailPage::class,
        ];
    }

    /**
     * @param Race $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
