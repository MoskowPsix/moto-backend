<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\GetUsersAppointmentRaceActionContract;
use App\Http\Requests\AppointmentRace\GetUsersAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\AppointmentRaceResource;
use App\Http\Resources\AppointmentRace\GetUsers\SuccessGetUsersAppointmentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\AppointmentRace;
use App\Models\Race;

class GetUsersAppointmentRaceAction implements GetUsersAppointmentRaceActionContract
{

    public function __invoke(int $id, GetUsersAppointmentRaceRequest $request): SuccessGetUsersAppointmentResource | NotFoundResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $race = Race::find($id);
        if (!$race) {
            return new NotFoundResource([]);
        }
        $app = AppointmentRace::where('race_id', $id)->get()->groupBy('grade.name');
        foreach ($app as $class => $userRacesGroup) {
            $formattedData[$class] = AppointmentRaceResource::collection($userRacesGroup);
        }
        if (!isset($formattedData)) {
            return new NotFoundResource([]);
        }
        return SuccessGetUsersAppointmentResource::make($formattedData);
    }
}
