<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Race;

use App\Traits\MoonShine\Resources\RaceResourceTrait;
use App\Traits\MoonShine\Resources\TrackResourceTrait;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Files;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;

class RaceDetailPage extends DetailPage
{
    use TrackResourceTrait, RaceResourceTrait;
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название гонки', 'name'),
            Textarea::make('Описание', 'desc'),
            Date::make('Дата и время', 'date_start'),
            Date::make('Старт регистрации', 'record_start'),
            Date::make('Конец регистрации', 'record_end'),
            Checkbox::make('Работает', 'is_work'),
            Image::make('Фото', 'images')->multiple(),
            File::make('Файл положения', 'position_file'),
            File::make('Файл регламента', 'results_file'),
            File::make('Файл с итогами', 'pdf_files')->multiple(),
            $this->status(),
            $this->user(),
            $this->track(),
            Date::make('Создано', 'created_at'),
            Date::make('Обновлено', 'updated_at'),
            $this->commission(),
            $this->grades(),
            $this->appointmentsCount(),
            $this->appointments(),
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
