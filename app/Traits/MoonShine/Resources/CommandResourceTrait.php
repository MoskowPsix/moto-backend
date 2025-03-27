<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\LocationResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\CommandResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;

trait CommandResourceTrait
{
    public function coach(): BelongsToMany
    {
        return BelongsToMany::make('Тренера', 'coaches', resource: UserResource::class)->searchable();
    }
    public function owner(): BelongsTo
    {
        return BelongsTo::make('Владелец', 'user', resource: UserResource::class)->searchable();
    }
    public function racers(): BelongsToMany
    {
        return BelongsToMany::make('Гонщики', 'members', resource: UserResource::class)->searchable();
    }

    public function location(): BelongsTo
    {
        return BelongsTo::make('Область', 'location', resource: LocationResource::class)->searchable();
    }
}
