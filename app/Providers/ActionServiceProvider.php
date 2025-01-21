<?php

namespace App\Providers;

use App\Contracts\Actions\Race\CreateRaceActionContract;
use App\Contracts\Actions\Role\ChangeRoleForDefaultUserActionContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Contracts\Actions\Auth\LoginActionContract::class                          => \App\Actions\Auth\LoginAction::class,
        \App\Contracts\Actions\Auth\RegisterActionContract::class                       => \App\Actions\Auth\RegisterAction::class,
        \App\Contracts\Actions\Auth\LogoutActionContract::class                         => \App\Actions\Auth\LogoutAction::class,
        \App\Contracts\Actions\Track\GetTracksActionContract::class                     => \App\Actions\Track\GetTracksAction::class,
        \App\Contracts\Actions\Track\CreateTracksActionContract::class                  => \App\Actions\Track\CreateTracksAction::class,
        \App\Contracts\Actions\Track\GetTrackForIdActionContract::class                 => \App\Actions\Track\GetTrackForIdAction::class,
        \App\Contracts\Actions\Role\GetChangeRolesActionContract::class                 => \App\Actions\Role\GetChangeRolesAction::class,
        \App\Contracts\Actions\Role\ChangeRoleForDefaultUserActionContract::class       => \App\Actions\Role\ChangeRoleForDefaultUserAction::class,
        \App\Contracts\Actions\Race\GetRaceActionContract::class                        => \App\Actions\Race\GetRaceAction::class,
        \App\Contracts\Actions\Race\GetForIdRaceActionContract::class                   => \App\Actions\Race\GetForIdRaceAction::class,
        \App\Contracts\Actions\Race\CreateRaceActionContract::class                     => \App\Actions\Race\CreateRaceAction::class,
        \App\Contracts\Actions\PersonalInfo\CreatePersonalInfoActionContract::class     => \App\Actions\PersonalInfo\CreatePersonalInfoAction::class,

    ];
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
