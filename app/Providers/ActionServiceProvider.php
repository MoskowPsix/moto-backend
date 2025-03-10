<?php

namespace App\Providers;

use App\Contracts\Actions\Commands\GenerateLocationCsvActionContract;
use App\Contracts\Actions\Controllers\Grade\GetForIdGradeActionContract;
use App\Contracts\Actions\Controllers\Grade\GetGradeActionContract;
use App\Contracts\Actions\Controllers\Grade\UpdateGradeActionContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        // Command
        \App\Contracts\Actions\Commands\CreateUserForRaceCommandActionContracts::class                              => \App\Actions\Commands\CreateUserForRaceCommandAction::class,
        \App\Contracts\Actions\Commands\GenerateLocationCsvActionContract::class                                    => \App\Actions\Commands\GenerateLocationCsvAction::class,

        // Controller
        \App\Contracts\Actions\Controllers\Auth\LoginActionContract::class                                          => \App\Actions\Controllers\Auth\LoginAction::class,
        \App\Contracts\Actions\Controllers\Auth\RegisterActionContract::class                                       => \App\Actions\Controllers\Auth\RegisterAction::class,
        \App\Contracts\Actions\Controllers\Auth\LogoutActionContract::class                                         => \App\Actions\Controllers\Auth\LogoutAction::class,
        \App\Contracts\Actions\Controllers\Track\GetTracksActionContract::class                                     => \App\Actions\Controllers\Track\GetTracksAction::class,
        \App\Contracts\Actions\Controllers\Track\CreateTracksActionContract::class                                  => \App\Actions\Controllers\Track\CreateTracksAction::class,
        \App\Contracts\Actions\Controllers\Track\GetTrackForIdActionContract::class                                 => \App\Actions\Controllers\Track\GetTrackForIdAction::class,
        \App\Contracts\Actions\Controllers\Track\UpdateTrackActionContract::class                                   => \App\Actions\Controllers\Track\UpdateTrackAction::class,
        \App\Contracts\Actions\Controllers\Role\GetChangeRolesActionContract::class                                 => \App\Actions\Controllers\Role\GetChangeRolesAction::class,
        \App\Contracts\Actions\Controllers\Role\ChangeRoleForDefaultUserActionContract::class                       => \App\Actions\Controllers\Role\ChangeRoleForDefaultUserAction::class,
        \App\Contracts\Actions\Controllers\Race\GetRaceActionContract::class                                        => \App\Actions\Controllers\Race\GetRaceAction::class,
        \App\Contracts\Actions\Controllers\Race\GetForIdRaceActionContract::class                                   => \App\Actions\Controllers\Race\GetForIdRaceAction::class,
        \App\Contracts\Actions\Controllers\Race\CreateRaceActionContract::class                                     => \App\Actions\Controllers\Race\CreateRaceAction::class,
        \App\Contracts\Actions\Controllers\Race\UpdateRaceActionContract::class                                     => \App\Actions\Controllers\Race\UpdateRaceAction::class,
        \App\Contracts\Actions\Controllers\Race\ToggleIsWorkRaceActionContract::class                               => \App\Actions\Controllers\Race\ToggleIsWorkRaceAction::class,
        \App\Contracts\Actions\Controllers\PersonalInfo\CreatePersonalInfoActionContract::class                     => \App\Actions\Controllers\PersonalInfo\CreatePersonalInfoAction::class,
        \App\Contracts\Actions\Controllers\PersonalInfo\UpdatePersonalInfoActionContract::class                     => \App\Actions\Controllers\PersonalInfo\UpdatePersonalInfoAction::class,
        \App\Contracts\Actions\Controllers\Document\CreateDocumentActionContract::class                             => \App\Actions\Controllers\Document\CreateDocumentAction::class,
        \App\Contracts\Actions\Controllers\Document\GetDocumentForUserActionContract::class                         => \App\Actions\Controllers\Document\GetDocumentForUserAction::class,
        \App\Contracts\Actions\Controllers\Document\GetDocumentForUserByIdActionContract::class                     => \App\Actions\Controllers\Document\GetDocumentForUserByIdAction::class,
        \App\Contracts\Actions\Controllers\Document\GetFileDocumentActionContract::class                            => \App\Actions\Controllers\Document\GetFileDocumentAction::class,
        \App\Contracts\Actions\Controllers\Document\UpdateDocumentActionContract::class                             => \App\Actions\Controllers\Document\UpdateDocumentAction::class,
        \App\Contracts\Actions\Controllers\Document\DeleteDocumentActionContract::class                             => \App\Actions\Controllers\Document\DeleteDocumentAction::class,
        \App\Contracts\Actions\Controllers\AppointmentRace\ToggleAppointmentRaceActionContract::class               => \App\Actions\Controllers\AppointmentRace\ToggleAppointmentRaceAction::class,
        \App\Contracts\Actions\Controllers\AppointmentRace\DeleteAppointmentRaceActionContract::class               => \App\Actions\Controllers\AppointmentRace\DeleteAppointmentRaceAction::class,
        \App\Contracts\Actions\Controllers\AppointmentRace\GetUsersAppointmentRaceActionContract::class             => \App\Actions\Controllers\AppointmentRace\GetUsersAppointmentRaceAction::class,
        \App\Contracts\Actions\Controllers\AppointmentRace\CreateTableAppointmentRaceUserActionContract::class      => \App\Actions\Controllers\AppointmentRace\CreateTableAppointmentRaceUserAction::class,
        \App\Contracts\Actions\Controllers\User\UpdateUserActionContract::class                                     => \App\Actions\Controllers\User\UpdateUserAction::class,
        \App\Contracts\Actions\Controllers\User\GetUserForIdActionContract::class                                   => \App\Actions\Controllers\User\GetUserForIdAction::class,
        \App\Contracts\Actions\Controllers\VerificationEmail\VerificationActionContract::class                      => \App\Actions\Controllers\VerificationEmail\VerificationAction::class,
        \App\Contracts\Actions\Controllers\VerificationEmail\SendActionContract::class                              => \App\Actions\Controllers\VerificationEmail\SendAction::class,
        \App\Contracts\Actions\Controllers\Location\GetLocationActionContract::class                                => \App\Actions\Controllers\Location\GetLocationAction::class,
        \App\Contracts\Actions\Controllers\Grade\CreateGradeActionContract::class                                   => \App\Actions\Controllers\Grade\CreateGradeAction::class,
        \App\Contracts\Actions\Controllers\Grade\GetForIdGradeActionContract::class                                 => \App\Actions\Controllers\Grade\GetForIdGradeAction::class,
        \App\Contracts\Actions\Controllers\Grade\GetGradeActionContract::class                                      => \App\Actions\Controllers\Grade\GetGradeAction::class,
        \App\Contracts\Actions\Controllers\Grade\UpdateGradeActionContract::class                                   => \App\Actions\Controllers\Grade\UpdateGradeAction::class,
        \App\Contracts\Actions\Controllers\Command\CreateCommandActionContract::class                               => \App\Actions\Controllers\Command\CreateCommandAction::class,
        \App\Contracts\Actions\Controllers\Command\GetForIdCommandActionContract::class                             => \App\Actions\Controllers\Command\GetForIdCommandAction::class,
        \App\Contracts\Actions\Controllers\Command\GetCommandActionContract::class                                  => \App\Actions\Controllers\Command\GetCommandAction::class,
        \App\Contracts\Actions\Controllers\Command\UpdateCommandActionContract::class                               => \App\Actions\Controllers\Command\UpdateCommandAction::class,
        \App\Contracts\Actions\Controllers\RecoveryPassword\SendRecoveryPasswordActionContract::class               => \App\Actions\Controllers\RecoveryPassword\SendRecoveryPasswordAction::class,
        \App\Contracts\Actions\Controllers\RecoveryPassword\RecoveryRecoveryPasswordActionContract::class           => \App\Actions\Controllers\RecoveryPassword\RecoveryRecoveryPasswordAction::class,
        \App\Contracts\Actions\Controllers\Store\CreateStoreActionContract::class                                   => \App\Actions\Controllers\Store\CreateStoreAction::class,
        \App\Contracts\Actions\Controllers\Attendance\CreateAttendanceActionContract::class                         => \App\Actions\Controllers\Attendance\CreateAttendanceAction::class,
        \App\Contracts\Actions\Controllers\Attendance\GetForIdAttendanceActionContract::class                       => \App\Actions\Controllers\Attendance\GetAttendanceForIdAction::class,
        \App\Contracts\Actions\Controllers\Attendance\UpdateAttendanceActionContract::class                         => \App\Actions\Controllers\Attendance\UpdateAttendanceAction::class,
        \App\Contracts\Actions\Controllers\Attendance\DeleteAttendanceActionContract::class                         => \App\Actions\Controllers\Attendance\DeleteAttendanceAction::class,
        \App\Contracts\Actions\Controllers\Transaction\CreateTransactionActionContract::class                       => \App\Actions\Controllers\Transaction\CreateTransactionAction::class,
        \App\Contracts\Actions\Controllers\Transaction\ResultTransactionActionContract::class                       => \App\Actions\Controllers\Transaction\ResultTransactionAction::class,
        \App\Contracts\Actions\Controllers\Transaction\SuccessTransactionActionContract::class                      => \App\Actions\Controllers\Transaction\SuccessTransactionAction::class,

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
