<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface CreateTableAppointmentRaceUserActionContract
{
    public function __invoke(int $id): SuccessCreateTableAppointmentRaceResource | NotUserPermissionResource | NotFoundResource;
}
