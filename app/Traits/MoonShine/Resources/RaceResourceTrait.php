<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\TrackResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;

trait RaceResourceTrait
{
    public function track(): BelongsTo
    {
        return BelongsTo::make('Трасса', 'track', resource: TrackResource::class)->searchable();
    }
    public function appointments(): BelongsToMany
    {
        return BelongsToMany::make('Заявки', 'appointments', resource: \App\MoonShine\Resources\UserResource::class)->searchable()->selectMode();
    }
    public function appointmentsCount(): BelongsToMany
    {
        return BelongsToMany::make('Количество заявок', 'appointments', resource: \App\MoonShine\Resources\UserResource::class)->onlyCount();
    }
}
