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
use MoonShine\UI\Fields\Textarea;
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
            Text::make('Название', 'name')->required(),
            Text::make('Адрес', 'address')->required(),
            Image::make('images')->multiple()->dir(isset($item->id) ? "/track/$item->id" : "/track"),
            Text::make('Координаты', 'point',)
                ->placeholder('POINT(<latitude> <longitude>)')
                ->onBeforeRender(function (Field $item) {
                    if (empty($item->toArray()['value'])) {
                        $item->setValue("POINT(<latitude> <longitude>)");
                        return $item;
                    }
                    $value = json_decode($item->toArray()['value']);
                    $item->setValue("POINT({$value->coordinates[0]} {$value->coordinates[1]})");
                    return $item;
                })
            ->required(),
            Number::make('Длина', 'length'),
            Number::make('Повороты', 'turns'),
            Textarea::make('Описание', 'desc'),
            Json::make('Спецификации трассы', 'spec')
                ->fields([
                    Text::make('Название','title'),
                    Text::make('Значение', 'value'),
                ]),
            Json::make('Спецификации трассы', 'contacts')
                ->fields([
                    Text::make('Название','title'),
                    Text::make('Значение', 'value'),
                ]),
            $this->user()->required(),
            $this->level()->required()
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
