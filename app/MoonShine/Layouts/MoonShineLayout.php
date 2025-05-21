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
use App\MoonShine\Resources\GradeResource;
use App\MoonShine\Resources\CommandResource;
use App\MoonShine\Resources\LocationResource;
use App\MoonShine\Resources\StoreResource;
use App\MoonShine\Resources\TransactionResource;
use App\MoonShine\Resources\AttendanceResource;
use App\MoonShine\Resources\PhoneResource;
use App\MoonShine\Resources\StatusResource;
use App\MoonShine\Resources\DegreeResource;
use App\MoonShine\Resources\CupResource;
use App\MoonShine\Resources\DistrictResource;
use App\MoonShine\Resources\RaceResultsResource;

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
                MenuItem::make('Statuses', StatusResource::class, 'minus-circle'),
                MenuItem::make('Трассы', TrackResource::class, 'map-pin'),
                MenuItem::make('Гонки', RaceResource::class, 'map'),
                MenuItem::make('Таблицы', GoogleSheetResource::class, 'clipboard-document-list'),
//            MenuItem::make('Levels', LevelResource::class),
                MenuItem::make('Сервисы', ServiceResource::class, 'square-3-stack-3d'),
                MenuItem::make('Классы', GradeResource::class, 'beaker'),
                MenuItem::make('Команды', CommandResource::class, 'users'),
                MenuItem::make('Магазины', StoreResource::class, 'building-storefront'),
                MenuItem::make('Транзакции', TransactionResource::class, 'credit-card'),
                MenuItem::make('Телефоны', PhoneResource::class, 'device-phone-mobile'),
                MenuItem::make('Уровни', DegreeResource::class, 'chevron-double-up'),
                MenuItem::make('Кубки', CupResource::class, 'trophy'),
                MenuItem::make('Округа', DistrictResource::class, 'map-pin'),
                MenuItem::make('Локации', LocationResource::class, 'globe-alt'),
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
