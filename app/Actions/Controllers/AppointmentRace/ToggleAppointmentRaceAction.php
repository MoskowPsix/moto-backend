<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\ToggleAppointmentRaceActionContract;
use App\Http\Requests\AppointmentRace\ToogleAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\AppointmentRace;
use App\Models\Race;

class ToggleAppointmentRaceAction implements ToggleAppointmentRaceActionContract
{

    public function __invoke(int $id, ToogleAppointmentRaceRequest $request): SuccessCreateAppointmentRaceResource | NotFoundResource | SuccessDeleteAppointmentRaceResource
    {
        $user = auth()->user();
        $race = Race::find($id);
        if (!$race) {
            return new NotFoundResource([]);
        }
        if (!$race->appointments()->where('user_id', $user->id)->exists()) {
            return $this->createAppointment($user->id, $race->id, $request->data);
        } else {
            return $this->deleteAppointment($user->id, $race->id);
        }
    }

    private function deleteAppointment(int $user_id, int $race_id): SuccessDeleteAppointmentRaceResource
    {
        $val = AppointmentRace::where('user_id', $user_id)->where('race_id', $race_id)->first();
        $val->delete();
        return SuccessDeleteAppointmentRaceResource::make([]);
    }
    private function createAppointment(int $user_id, int $race_id, $data): SuccessCreateAppointmentRaceResource
    {
        AppointmentRace::create([
            'user_id' => $user_id,
            'race_id' => $race_id,
            'data'    => $data,
        ]);
        return new SuccessCreateAppointmentRaceResource([]);
    }
}
