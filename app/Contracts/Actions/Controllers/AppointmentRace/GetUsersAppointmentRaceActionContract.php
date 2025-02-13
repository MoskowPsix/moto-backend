<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Requests\AppointmentRace\GetUsersAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\GetUsers\SuccessGetUsersAppointmentResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetUsersAppointmentRaceActionContract
{
    public function __invoke(int $id, GetUsersAppointmentRaceRequest $request): SuccessGetUsersAppointmentResource | NotFoundResource;
}
