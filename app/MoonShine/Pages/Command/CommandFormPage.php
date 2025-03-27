<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Command;

use App\Traits\MoonShine\Resources\CommandResourceTrait;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use Throwable;

class CommandFormPage extends FormPage
{
    use CommandResourceTrait;
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название команды', 'name')->sortable(),
            Image::make('Аватар', 'avatar')->multiple(),
            $this->owner(),
            $this->coach()->selectMode(),
            Text::make('Город', 'city')->sortable(),
            $this->location(),
            $this->racers()->selectMode(),
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
