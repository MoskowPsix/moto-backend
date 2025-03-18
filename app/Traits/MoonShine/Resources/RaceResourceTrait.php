<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\StatusResource;
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
        return BelongsToMany::make('Заявки', 'appointments', resource: \App\MoonShine\Resources\UserResource::class)->onlyCount();
    }
    public function grades(): BelongsToMany
    {
        return BelongsToMany::make('Классы', 'grades', resource: \App\MoonShine\Resources\GradeResource::class)->searchable()->selectMode();
    }
    public function commission(): BelongsToMany
    {
        return BelongsToMany::make('Комиссия', 'commissions', resource: \App\MoonShine\Resources\UserResource::class)->searchable()->selectMode();
    }
    public function status(): BelongsTo
    {
        return BelongsTo::make('Статус', 'status', resource: StatusResource::class)->searchable();
    }
}
