<?php

namespace App\Actions\Controllers\Attendance;

use App\Contracts\Actions\Controllers\Attendance\CreateAttendanceActionContract;
use App\Http\Requests\Attendance\CreateAttendanceRequest;
use App\Http\Resources\Attendance\Create\SuccessCreateAttendanceResource;
use App\Models\Attendance;

class CreateAttendanceAction implements CreateAttendanceActionContract
{
    public function __invoke(CreateAttendanceRequest $request): SuccessCreateAttendanceResource
    {
        $attendance = Attendance::create([
            'name'          => $request->name,
            'desc'          => $request->desc,
            'price'         => $request->price,
            'track_id'      => $request->trackId,
        ]);
        return SuccessCreateAttendanceResource::make($attendance);
    }
}
