<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Track;

use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Text;
use Throwable;

class TrackFormPage extends FormPage
{
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
                })
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
