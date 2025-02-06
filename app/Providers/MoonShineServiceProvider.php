<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Contracts\Core\ResourceContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\TrackResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Pages\Service\ServiceIndexPage;
use App\MoonShine\Pages\Service\ServiceDetailPage;
use App\MoonShine\Pages\Service\ServiceFormPage;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\RoleResource;
use App\MoonShine\Resources\LevelResource;
use App\MoonShine\Resources\RaceResource;
use MoonShine\Laravel\Enums\Ability;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        $config->authEnable();
        $config->authorizationRules(
            static function (ResourceContract $resource, User $user, Ability $ability, Model $item): bool {
                $role = new \App\Constants\RoleConstant();
                return $user->hasRole($role::ROOT) || $user->hasRole($role::ADMIN);
            }
        );
        $core
            ->resources([

                TrackResource::class,
                UserResource::class,
                RoleResource::class,
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
