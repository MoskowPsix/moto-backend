<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\LevelResource;
use App\MoonShine\Resources\StoreResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

trait TrackResourceTrait
{
    public function user(): BelongsTo
    {
        return BelongsTo::make('Владелец', 'user', resource: \App\MoonShine\Resources\UserResource::class)->searchable();
    }

    public function level(): BelongsTo
    {
        return BelongsTo::make('Сложность', 'level', resource: LevelResource::class);
    }

    public function store(): BelongsTo
    {
        return BelongsTo::make('Магазин', 'store', resource: StoreResource::class);
    }
}
