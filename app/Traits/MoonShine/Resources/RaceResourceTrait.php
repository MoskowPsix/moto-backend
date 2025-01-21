<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\TrackResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

trait RaceResourceTrait
{
    public function track(): BelongsTo
    {
        return BelongsTo::make('Трасса', 'track', resource: TrackResource::class)->searchable();
    }
}
