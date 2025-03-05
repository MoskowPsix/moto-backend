<?php

namespace App\Actions\Controllers\Attendance;

use App\Contracts\Actions\Controllers\Attendance\UpdateAttendanceActionContract;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\Attendance\Update\SuccessUpdateAttendanceResource;
use App\Models\Attendance;

class UpdateAttendanceAction implements UpdateAttendanceActionContract
{

    public function __invoke(int $id, UpdateAttendanceRequest $request): SuccessUpdateAttendanceResource
    {
        $attendance = Attendance::find($id);
        $attendance->update([
            'name'          => $request->name ?? $attendance->name,
            'desc'          => $request->desc ?? $attendance->desc,
            'price'         => $request->price ?? $attendance->price,
            'track_id'      => $request->trackId ?? $attendance->track_id,
        ]);

        return SuccessUpdateAttendanceResource::make($attendance);
    }
}
