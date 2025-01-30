<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Track;

use App\Traits\MoonShine\Resources\TrackResourceTrait;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;

class TrackDetailPage extends DetailPage
{
    use TrackResourceTrait;
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $item = $this->getResource()->getItem();
        return [
            Image::make('images')->multiple()->dir("/track/$item->id"),
            Checkbox::make('Работает', 'is_work'),
            Checkbox::make('Бесплатное', 'free')->sortable(),
            Text::make('Название', 'name'),
            Text::make('Адрес', 'address'),
            Text::make('Местоположение', 'point'),
            Number::make('Длина', 'length'),
            Number::make('Повороты', 'turns'),
            Text::make('Описание', 'desc'),
            Json::make('Спецификации трассы', 'spec')
                ->fields([
                    Text::make('Название'),
                    Text::make('Значение'),
                ]),
            Json::make('Спецификации трассы', 'contacts')
                ->fields([
                    Text::make('Название','title'),
                    Text::make('Значение', 'value'),
                ]),
            $this->user(),
            $this->level(),
            Date::make('Создано', 'created_at'),
            Date::make('Обновлено', 'updated_at'),
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
