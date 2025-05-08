<?php

namespace App\Traits\MoonShine\Resources;

use App\Models\Attendance;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;

trait TransactionResourceTrait
{
    public function user(): BelongsTo
    {
        return BelongsTo::make('Пользователь', 'user', resource: \App\MoonShine\Resources\UserResource::class)->searchable();
    }
    public function attendances(): BelongsToMany
    {
        return BelongsToMany::make('Услуги', 'attendances', resource: \App\MoonShine\Resources\AttendanceResource::class)->selectMode();
    }
}
