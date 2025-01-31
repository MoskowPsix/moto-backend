<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Race;

use App\Traits\MoonShine\Resources\RaceResourceTrait;
use App\Traits\MoonShine\Resources\TrackResourceTrait;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use Throwable;

class RaceFormPage extends FormPage
{
    use TrackResourceTrait, RaceResourceTrait;

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $item = $this->getResource()->getItem();
        return [
            ID::make()->sortable(),
            Text::make('Название гонки', 'name'),
            Text::make('Описание', 'desc'),
            Text::make('Дата и время', 'date_start'),
            Checkbox::make('Работает', 'is_work'),
            Image::make('Фото', 'images')->multiple()->dir("/race/$item->id"),
            $this->user(),
            $this->track(),
            $this->appointments(),
            File::make('Файл положения', 'position_file')->dir("/race/$item->id"),
            File::make('Файл регламента', 'results_file')->dir("/race/$item->id"),
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
