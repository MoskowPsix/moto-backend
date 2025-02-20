<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\LocationResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\CommandResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

trait CommandResourceTrait
{
    public function user(): BelongsTo
    {
        return BelongsTo::make('Тренер', 'user', resource: UserResource::class)->searchable();
    }

    public function location(): BelongsTo
    {
        return BelongsTo::make('Область', 'location', resource: LocationResource::class)->searchable();
    }
}
