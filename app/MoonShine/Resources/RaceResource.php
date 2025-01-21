<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Race;
use App\MoonShine\Pages\Race\RaceIndexPage;
use App\MoonShine\Pages\Race\RaceFormPage;
use App\MoonShine\Pages\Race\RaceDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Pages\Page;

/**
 * @extends ModelResource<Race, RaceIndexPage, RaceFormPage, RaceDetailPage>
 */
class RaceResource extends ModelResource
{
    protected string $model = Race::class;
    protected bool $simplePaginate = true;
    protected string $title = 'Гонки';

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
