<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Requests\AppointmentRace\ToogleAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\Create\ExistsAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\GradeNotExistsAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\ManyDocumentAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;

interface ToggleAppointmentRaceActionContract
{
    public function __invoke(int $id, ToogleAppointmentRaceRequest $request):
    ManyDocumentAppointmentRaceResource|
    SuccessCreateAppointmentRaceResource|
    NotFoundResource|
    SuccessDeleteAppointmentRaceResource|
    ExistsAppointmentRaceResource|
    GradeNotExistsAppointmentRaceResource;
}
