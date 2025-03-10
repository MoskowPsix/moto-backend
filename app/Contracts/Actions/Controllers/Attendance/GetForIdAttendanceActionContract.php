<?php

namespace App\Contracts\Actions\Controllers\Attendance;

use App\Http\Requests\Attendance\GetForIdAttendanceRequest;
use App\Http\Resources\Attendance\GetAttendanceForId\SuccessGetAttendanceForIdResource;

interface GetForIdAttendanceActionContract
{
    public function __invoke(int $trackId, GetForIdAttendanceRequest $request): SuccessGetAttendanceForIdResource;
}
