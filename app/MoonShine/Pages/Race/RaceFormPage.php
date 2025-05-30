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
use MoonShine\UI\Fields\Textarea;
use Throwable;

class RaceFormPage extends FormPage
{
    use RaceResourceTrait, TrackResourceTrait;

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $item = $this->getResource()->getItem();
        return [
            ID::make()->sortable(),
            Text::make('Название гонки', 'name')->required(),
            Textarea::make('Описание', 'desc'),
            Date::make('Дата и время', 'date_start')->withTime()->required(),
            Date::make('Старт регистрации', 'record_start')->withTime(),
            Date::make('Конец регистрации', 'record_end')->withTime(),
            Checkbox::make('Работает', 'is_work')->required(),
            Image::make('Фото', 'images')->multiple()->dir(isset($item->id) ? "/race/$item->id" : "/race")->removable(),
            $this->location(),
            $this->status(),
            $this->user()->required(),
            $this->track()->nullable(),
            $this->commission(),
            $this->appointments(),
            $this->grades(),
            $this->cups(),
            File::make('Файл положения', 'position_file')->dir(isset($item->id) ? "/race/$item->id" : "/race")->keepOriginalFileName()->removable(),
            File::make('Файл регламента', 'results_file')->dir(isset($item->id) ? "/race/$item->id" : "/race")->keepOriginalFileName()->removable(),
            File::make('Файл с итогами', 'pdf_files')->dir(isset($item->id) ? "/race/$item->id" : "/race")->multiple(true)->keepOriginalFileName()->removable(),
            $this->results(),
            $this->store()->nullable(),
            $this->attendance()->nullable()->creatable(),
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
