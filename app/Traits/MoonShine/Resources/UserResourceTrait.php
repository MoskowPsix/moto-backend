<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\RaceResource;
use App\MoonShine\Resources\TrackResource;
use MoonShine\Laravel\Fields\Relationships\HasMany;

trait UserResourceTrait
{
    public function tracks(): HasMany
    {
        return HasMany::make('Трассы', 'tracks', resource: TrackResource::class);
    }
    public function races(): HasMany
    {
        return HasMany::make('Гонки', 'races', resource: RaceResource::class);
    }
}
