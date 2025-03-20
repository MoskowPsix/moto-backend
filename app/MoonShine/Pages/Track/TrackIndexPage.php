<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Track;

use App\Traits\MoonShine\Resources\RaceResourceTrait;
use App\Traits\MoonShine\Resources\TrackResourceTrait;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;

class TrackIndexPage extends IndexPage
{
    use TrackResourceTrait, RaceResourceTrait;
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
//            Checkbox::make('Работает', 'is_work')->sortable(),
            Text::make('Название', 'name')->sortable(),
            Text::make('Адрес', 'address')->sortable(),
            Image::make('Фото','images')->multiple(),
            Date::make('Создано', 'created_at')->sortable(),
            Date::make('Обновлено', 'updated_at')->sortable(),
            $this->location(),
        ];
    }

    protected function styles(): array
    {
        return [
            'table' => 'min-width: 1000px; overflow-x: auto;', // Устанавливаем минимальную ширину и добавляем прокрутку
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
