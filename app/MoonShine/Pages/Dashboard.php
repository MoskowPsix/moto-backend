<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Track;
use App\Models\User;
use App\MoonShine\Pages\Race\RaceIndexPage;
use App\MoonShine\Resources\RaceResource;
use App\MoonShine\Resources\TrackResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use App\Models\Race;

class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Приборная панель';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
	{
		return [
            MenuGroup::make('Контент', [
                MenuItem::make('Гонки', RaceResource::class, 'map'),
                MenuItem::make('Трассы', TrackResource::class, 'map-pin'),
                MenuItem::make('Пользователи', UserResource::class),
            ]),
            ValueMetric::make('Гонок')
            ->value(fn(): int => Race::all()->count()),
            ValueMetric::make('Трасс')
            ->value(fn(): int => Track::all()->count()),
            ValueMetric::make('Пользователей')
            ->value(fn(): int => User::all()->count()),
        ];
	}
}
