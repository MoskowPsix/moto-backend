<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Track;
use App\MoonShine\Pages\Track\TrackIndexPage;
use App\MoonShine\Pages\Track\TrackFormPage;
use App\MoonShine\Pages\Track\TrackDetailPage;
use Illuminate\Contracts\Database\Eloquent\Builder;


use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Track, TrackIndexPage, TrackFormPage, TrackDetailPage>
 */
class TrackResource extends ModelResource
{
    protected string $model = Track::class;
    protected bool $simplePaginate = true;

    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;
    protected string $column = 'name';

    protected string $title = 'Трассы';

    protected array $with = ['user'];

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [
            TrackIndexPage::class,
            TrackFormPage::class,
            TrackDetailPage::class,
        ];
    }
    protected function modifyItemQueryBuilder(Builder $builder): Builder
    {
        return $builder->selectRaw('*, ST_AsGeoJSON(point) as point');
    }

    protected function search(): array
    {
        return [
            'id',
            'name',
            'address',
            'length',
            'turns'
        ];
    }

    /**
     * @param Track $item
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
