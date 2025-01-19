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

/**
 * @extends ModelResource<Track, TrackIndexPage, TrackFormPage, TrackDetailPage>
 */
class TrackResource extends ModelResource
{
    protected string $model = Track::class;

    protected string $title = 'Tracks';

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
}
