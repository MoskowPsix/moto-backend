<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Race;

use App\Traits\MoonShine\Resources\RaceResourceTrait;
use App\Traits\MoonShine\Resources\TrackResourceTrait;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use Throwable;

class RaceIndexPage extends IndexPage
{
    use TrackResourceTrait, RaceResourceTrait;

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название гонки', 'name')->sortable(),
            Text::make('Дата и время', 'date_start')->sortable(),
            Checkbox::make('Работает', 'is_work')->sortable(),
            Image::make('Фото', 'images')->multiple(),
            $this->user(),
            $this->track(),
            $this->appointmentsCount(),
            Date::make('Создано', 'created_at')->sortable(),
            Date::make('Обновлено', 'updated_at')->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
