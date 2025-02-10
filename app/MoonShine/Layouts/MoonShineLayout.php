<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\RoleResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When};
use App\MoonShine\Resources\TrackResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\LevelResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Resources\RaceResource;
use App\MoonShine\Resources\GoogleSheetResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Система', [
                MenuItem::make('Пользователи', UserResource::class),
                MenuItem::make('Роли', RoleResource::class),
            ], 'cog-8-tooth'),
            MenuGroup::make('Разработчикам', [
                MenuItem::make('Telescope', '/telescope', 'rocket-launch'),
                MenuItem::make('Документация API', '/docs', 'code-bracket-square'),
            ], 'cpu-chip'),
            MenuGroup::make('Контент', [
                MenuItem::make('Трассы', TrackResource::class, 'map-pin'),
                MenuItem::make('Гонки', RaceResource::class, 'map'),
                MenuItem::make('Таблицы', GoogleSheetResource::class, 'clipboard-document-list'),
//            MenuItem::make('Levels', LevelResource::class),
                MenuItem::make('Сервисы', ServiceResource::class, 'square-3-stack-3d'),
            ], 'cube'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
