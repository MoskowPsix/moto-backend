<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;

interface DeleteAppointmentRaceActionContract
{
    public function __invoke(int $id): SuccessDeleteAppointmentRaceResource | NotFoundResource;


}
