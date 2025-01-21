<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\TrackResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Pages\Service\ServiceIndexPage;
use App\MoonShine\Pages\Service\ServiceDetailPage;
use App\MoonShine\Pages\Service\ServiceFormPage;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\LevelResource;
use App\MoonShine\Resources\RaceResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([

                TrackResource::class,
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                LevelResource::class,
                ServiceResource::class,
                RaceResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                ServiceIndexPage::class,
                ServiceDetailPage::class,
                ServiceFormPage::class,
            ])
        ;
    }
}
