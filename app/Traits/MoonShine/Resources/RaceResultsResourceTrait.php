<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\CommandResource;
use App\MoonShine\Resources\CupResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

trait RaceResultsResourceTrait
{
    public function user(): BelongsTo
    {
        return BelongsTo::make('Гонщик', 'user', resource: UserResource::class);
    }
    public function command(): BelongsTo
    {
        return BelongsTo::make('Команда', 'command', resource: CommandResource::class);
    }
    public function cup(): BelongsTo
    {
        return BelongsTo::make('Кубки', 'cup', resource: CupResource::class);
    }
}
