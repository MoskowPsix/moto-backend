<?php

namespace App\Traits\MoonShine\Resources;

use App\Models\PersonalInfo;
use MoonShine\Laravel\Fields\Relationships\HasOne;

trait UserResourceTrait
{
    public function personalInfo(): HasOne
    {
        return HasOne::make('Персональные данные', 'personalInfo', resource: \App\MoonShine\Resources\PersonalInfoResource::class);
    }
}
