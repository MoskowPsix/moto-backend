<?php

namespace App\Contracts\Actions\Controllers\Attendance;

use App\Http\Resources\Attendance\GetAttendanceForId\SuccessGetAttendanceForIdResource;

interface GetAttendanceForRaceIdActionContract
{
    public function __invoke(int $id): SuccessGetAttendanceForIdResource;
}
