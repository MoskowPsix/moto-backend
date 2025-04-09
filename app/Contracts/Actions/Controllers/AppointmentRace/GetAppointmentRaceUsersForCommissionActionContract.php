<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Requests\AppointmentRace\GetAppointmentRaceUsersForCommissionRequest;
use App\Http\Resources\AppointmentRace\SuccessGetAppointmentRaceUsersForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface GetAppointmentRaceUsersForCommissionActionContract
{
    public function __invoke(int $id, GetAppointmentRaceUsersForCommissionRequest $request):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessGetAppointmentRaceUsersForCommissionResource;
}
