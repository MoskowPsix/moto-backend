<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Requests\AppointmentRace\ToogleAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;

interface ToggleAppointmentRaceActionContract
{
    public function __invoke(int $id, ToogleAppointmentRaceRequest $request): SuccessCreateAppointmentRaceResource | NotFoundResource | SuccessDeleteAppointmentRaceResource;
}
