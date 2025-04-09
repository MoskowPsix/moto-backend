<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\GetAppointmentRaceUsersForCommissionActionContract;
use App\Http\Requests\AppointmentRace\GetAppointmentRaceUsersForCommissionRequest;
use App\Http\Resources\AppointmentRace\SuccessGetAppointmentRaceUsersForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use Illuminate\Pipeline\Pipeline;

class GetAppointmentRaceUsersForCommissionAction implements GetAppointmentRaceUsersForCommissionActionContract
{
    public function __invoke(int $id, GetAppointmentRaceUsersForCommissionRequest $request):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessGetAppointmentRaceUsersForCommissionResource
    {
        $race = Race::find($id);

        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $appr = AppointmentRace::where('race_id', $id);
        if (!$appr->exists()) {
            return NotFoundResource::make([]);
        }
        if (!$race->commissions()->where('users.id', auth()->user()->id)->exists())
        {
            return NotUserPermissionResource::make([]);
        }
        $users_q = $appr->with('location', 'documents', 'grade');

        $users = app(Pipeline::class)
            ->send($users_q)
            ->through([])
            ->via('apply')
            ->then(function ($races) use ($page, $limit, $request) {
                return $request->paginate ?
                    $races->simplePaginate($limit, ['*'], 'page',  $page) :
                    $races->get();
            });
        return SuccessGetAppointmentRaceUsersForCommissionResource::make($users);
    }
}
