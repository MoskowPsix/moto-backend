<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\LevelResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

trait TrackResourceTrait
{
    public function user(): BelongsTo
    {
        return BelongsTo::make('Владелец', 'user', resource: \App\MoonShine\Resources\MoonShineUserResource::class)->searchable();
    }

    public function level(): BelongsTo
    {
        return BelongsTo::make('Сложность', 'level', resource: LevelResource::class);
    }
}
