<?php

namespace App\Traits\MoonShine\Resources;

use App\MoonShine\Resources\CommandResource;
use App\MoonShine\Resources\PhoneResource;
use App\MoonShine\Resources\RaceResource;
use App\MoonShine\Resources\TrackResource;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\HasOne;

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
    public function commands(): HasMany
    {
        return HasMany::make('Команды', 'commands', resource: CommandResource::class);
    }
    public function phone(): HasOne
    {
        return HasOne::make('Телефон', 'phone', resource: PhoneResource::class);
    }
}
