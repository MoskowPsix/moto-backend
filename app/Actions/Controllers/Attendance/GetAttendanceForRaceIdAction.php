<?php

namespace App\Actions\Controllers\Attendance;

use \App\Contracts\Actions\Controllers\Attendance\GetAttendanceForRaceIdActionContract;
use App\Http\Requests\Attendance\GetForIdAttendanceRequest;
use App\Http\Resources\Attendance\GetAttendanceForId\SuccessGetAttendanceForIdResource;
use App\Models\Attendance;


class GetAttendanceForRaceIdAction implements \App\Contracts\Actions\Controllers\Attendance\GetAttendanceForRaceIdActionContract
{
    public function __invoke(int $id): SuccessGetAttendanceForIdResource
    {
        $attendance = Attendance::where('race_id', $id)->get();
        return SuccessGetAttendanceForIdResource::make($attendance);
    }
}
