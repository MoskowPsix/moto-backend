<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Store;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Throwable;

class StoreFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Логин', 'login')->sortable(),
            Text::make('Пароль 1', 'password_1')->sortable(),
            Text::make('Пароль 2', 'password_2')->sortable(),
            Text::make('Токен', 'token')->sortable(),
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
