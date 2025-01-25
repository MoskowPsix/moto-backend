<?php

namespace App\Actions\AppointmentRace;

use App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Models\Race;

class CreateTableAppointmentRaceUserAction implements  CreateTableAppointmentRaceUserActionContract
{

    public function __invoke(int $id)
    {
        $race = Race::find($id);
        if (auth()->user()->id !== $race->user()->id) {
            return false;
        }
        $users_q = $race->appointments()->with('documents', 'personalInfo');
        dd($users_q->get()->toArray());
    }
}
