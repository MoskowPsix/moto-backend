<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Requests\AppointmentRace\CheckedAppointmentRaceForCommissionRequest;
use App\Http\Resources\AppointmentRace\Checked\SuccessCheckedAppointmentRaceForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface CheckedAppointmentRaceForCommissionActionContract
{
    public function __invoke(int $app_id, CheckedAppointmentRaceForCommissionRequest $request):
    SuccessCheckedAppointmentRaceForCommissionResource|
    NotFoundResource|
    NotUserPermissionResource;
}
