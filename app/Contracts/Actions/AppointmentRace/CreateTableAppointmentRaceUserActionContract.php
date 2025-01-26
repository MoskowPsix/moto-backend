<?php

namespace App\Contracts\Actions\AppointmentRace;

use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface CreateTableAppointmentRaceUserActionContract
{
    public function __invoke(int $id): SuccessCreateTableAppointmentRaceResource | NotUserPermissionResource;
}
