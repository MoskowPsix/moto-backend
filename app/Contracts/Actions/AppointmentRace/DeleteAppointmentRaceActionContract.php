<?php

namespace App\Contracts\Actions\AppointmentRace;

use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;

interface DeleteAppointmentRaceActionContract
{
    public function __invoke(int $id): SuccessDeleteAppointmentRaceResource | NotFoundResource;


}
