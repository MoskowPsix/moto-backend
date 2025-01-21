<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Track;

use App\Traits\MoonShine\Resources\TrackResourceTrait;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;

class TrackFormPage extends FormPage
{
    use TrackResourceTrait;
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $item = $this->getResource()->getItem();
        return [
            Text::make('Название', 'name'),
            Text::make('Адрес', 'address'),
            Image::make('images')->multiple()->dir("/track/$item->id"),
            Text::make('Координаты', 'point',)
                ->placeholder('POINT(<latitude> <longitude>)')
                ->onBeforeRender(function (Field $item) {
                    $value = json_decode($item->toArray()['value']);
                    $item->setValue("POINT({$value->coordinates[0]} {$value->coordinates[1]})");
                    return $item;
                }),
            Number::make('Длина', 'length'),
            Number::make('Повороты', 'turns'),
            Text::make('Описание', 'desc'),
            Json::make('Спецификации трассы', 'spec')
                ->fields([
                    Text::make('Название','title'),
                    Text::make('Значение', 'value'),
                ]),
            $this->user(),
            $this->level()
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
