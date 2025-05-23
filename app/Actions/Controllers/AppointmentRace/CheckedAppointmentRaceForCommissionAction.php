<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\CheckedAppointmentRaceForCommissionActionContract;
use App\Http\Requests\AppointmentRace\CheckedAppointmentRaceForCommissionRequest;
use App\Http\Resources\AppointmentRace\Checked\SuccessCheckedAppointmentRaceForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use Carbon\Carbon;

class CheckedAppointmentRaceForCommissionAction implements CheckedAppointmentRaceForCommissionActionContract
{
    public function __invoke(int $app_id, CheckedAppointmentRaceForCommissionRequest $request):
    SuccessCheckedAppointmentRaceForCommissionResource|
    NotFoundResource|
    NotUserPermissionResource
    {
        $app_q = AppointmentRace::where('id', $app_id);

        if (!$app_q->exists()) {
            return NotFoundResource::make([]);
        }

        if (!$app_q->first()->race()->first()->commissions()->where('users.id', auth()->user()->id)->exists())
        {
            return NotUserPermissionResource::make([]);
        }

        $app_q->update([
            'comment'       => $request->comment,
            'commission_id' => auth()->user()->id,
            'is_checked'    => $request->checked ? Carbon::now() : null,
        ]);

        return SuccessCheckedAppointmentRaceForCommissionResource::make($request->checked);
    }
}
