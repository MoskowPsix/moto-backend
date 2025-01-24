<?php

namespace App\Actions\AppointmentRace;

use App\Contracts\Actions\AppointmentRace\GetUsersAppointmentRaceActionContract;
use App\Http\Requests\AppointmentRace\GetUsersAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\GetUsers\SuccessGetUsersAppointmentResource;
use App\Http\Resources\Errors\NotFoundResource;
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
        $users = $request->paginate ?
            $race->appointments()->simplePaginate($limit, ['*'], 'page',  $page) :
            $race->appointments()->get();
        return SuccessGetUsersAppointmentResource::make($users);
    }
}
