<?php

namespace App\Contracts\Actions\AppointmentRace;

use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;

interface ToggleAppointmentRaceActionContract
{
    public function __invoke(int $id): SuccessCreateAppointmentRaceResource | NotFoundResource | SuccessDeleteAppointmentRaceResource;
}
