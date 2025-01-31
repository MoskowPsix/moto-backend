<?php

namespace App\Providers;

use App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Contracts\Actions\Document\GetDocumentForUserByIdActionContract;
use App\Contracts\Actions\Race\CreateRaceActionContract;
use App\Contracts\Actions\Role\ChangeRoleForDefaultUserActionContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Contracts\Actions\Auth\LoginActionContract::class                                      => \App\Actions\Auth\LoginAction::class,
        \App\Contracts\Actions\Auth\RegisterActionContract::class                                   => \App\Actions\Auth\RegisterAction::class,
        \App\Contracts\Actions\Auth\LogoutActionContract::class                                     => \App\Actions\Auth\LogoutAction::class,
        \App\Contracts\Actions\Track\GetTracksActionContract::class                                 => \App\Actions\Track\GetTracksAction::class,
        \App\Contracts\Actions\Track\CreateTracksActionContract::class                              => \App\Actions\Track\CreateTracksAction::class,
        \App\Contracts\Actions\Track\GetTrackForIdActionContract::class                             => \App\Actions\Track\GetTrackForIdAction::class,
        \App\Contracts\Actions\Role\GetChangeRolesActionContract::class                             => \App\Actions\Role\GetChangeRolesAction::class,
        \App\Contracts\Actions\Role\ChangeRoleForDefaultUserActionContract::class                   => \App\Actions\Role\ChangeRoleForDefaultUserAction::class,
        \App\Contracts\Actions\Race\GetRaceActionContract::class                                    => \App\Actions\Race\GetRaceAction::class,
        \App\Contracts\Actions\Race\GetForIdRaceActionContract::class                               => \App\Actions\Race\GetForIdRaceAction::class,
        \App\Contracts\Actions\Race\CreateRaceActionContract::class                                 => \App\Actions\Race\CreateRaceAction::class,
        \App\Contracts\Actions\PersonalInfo\CreatePersonalInfoActionContract::class                 => \App\Actions\PersonalInfo\CreatePersonalInfoAction::class,
        \App\Contracts\Actions\PersonalInfo\UpdatePersonalInfoActionContract::class                 => \App\Actions\PersonalInfo\UpdatePersonalInfoAction::class,
        \App\Contracts\Actions\Document\CreateDocumentActionContract::class                         => \App\Actions\Document\CreateDocumentAction::class,
        \App\Contracts\Actions\Document\GetDocumentForUserActionContract::class                     => \App\Actions\Document\GetDocumentForUserAction::class,
        \App\Contracts\Actions\Document\GetDocumentForUserByIdActionContract::class                 => \App\Actions\Document\GetDocumentForUserByIdAction::class,
        \App\Contracts\Actions\Document\UpdateDocumentActionContract::class                         => \App\Actions\Document\UpdateDocumentAction::class,
        \App\Contracts\Actions\Document\DeleteDocumentActionContract::class                         => \App\Actions\Document\DeleteDocumentAction::class,
        \App\Contracts\Actions\AppointmentRace\ToggleAppointmentRaceActionContract::class           => \App\Actions\AppointmentRace\ToggleAppointmentRaceAction::class,
        \App\Contracts\Actions\AppointmentRace\DeleteAppointmentRaceActionContract::class           => \App\Actions\AppointmentRace\DeleteAppointmentRaceAction::class,
        \App\Contracts\Actions\AppointmentRace\GetUsersAppointmentRaceActionContract::class         => \App\Actions\AppointmentRace\GetUsersAppointmentRaceAction::class,
        \App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract::class  => \App\Actions\AppointmentRace\CreateTableAppointmentRaceUserAction::class,
        \App\Contracts\Actions\User\UpdateUserActionContract::class                                  => \App\Actions\User\UpdateUserAction::class,
        \App\Contracts\Actions\User\GetUserForIdActionContract::class                                  => \App\Actions\User\GetUserForIdAction::class,

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
