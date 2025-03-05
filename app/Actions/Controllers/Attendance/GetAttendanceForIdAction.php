<?php

namespace App\Actions\Controllers\Attendance;

use App\Contracts\Actions\Controllers\Attendance\GetForIdAttendanceActionContract;
use App\Http\Requests\Attendance\GetForIdAttendanceRequest;
use App\Http\Resources\Attendance\GetAttendanceForId\SuccessGetAttendanceForIdResource;
use App\Models\Attendance;

class GetAttendanceForIdAction implements GetForIdAttendanceActionContract
{

    public function __invoke(int $trackId, GetForIdAttendanceRequest $request): SuccessGetAttendanceForIdResource
    {
        $attendance = Attendance::where('track_id', $trackId)->get();
        return SuccessGetAttendanceForIdResource::make($attendance->first());
    }
}
