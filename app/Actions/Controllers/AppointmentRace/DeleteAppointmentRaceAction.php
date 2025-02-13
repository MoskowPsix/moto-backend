<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\DeleteAppointmentRaceActionContract;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Race;

class DeleteAppointmentRaceAction implements DeleteAppointmentRaceActionContract
{

    public function __invoke(int $id): SuccessDeleteAppointmentRaceResource | NotFoundResource
    {
        $user = auth()->user();
        $race = Race::find($id);
        if (!$race) {
            return new NotFoundResource([]);
        }
        $appointmentRace = $race->appointmentRaces()->where('user_id', $user->id);
        if (!$appointmentRace->exists()) {
            return new NotFoundResource([]);
        }
        $appointmentRace->delete();
        return new SuccessDeleteAppointmentRaceResource([]);
    }
}
