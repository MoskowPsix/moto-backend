<?php

namespace App\Actions\Controllers\Attendance;

use App\Contracts\Actions\Controllers\Attendance\UpdateAttendanceActionContract;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\Attendance\Update\SuccessUpdateAttendanceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Attendance;

class UpdateAttendanceAction implements UpdateAttendanceActionContract
{

    public function __invoke(int $id, UpdateAttendanceRequest $request): SuccessUpdateAttendanceResource|NotFoundResource|NotUserPermissionResource
    {
        $attendance = Attendance::find($id);
        if(!isset($attendance)) {
            return NotFoundResource::make([]);
        }
        if ($attendance->track->user_id !== auth()->id()) {
            return NotUserPermissionResource::make([]);
        }
        $attendance->update([
            'name'          => $request->name ?? $attendance->name,
            'desc'          => $request->desc ?? $attendance->desc,
            'price'         => $request->price ?? $attendance->price,
            'track_id'      => $request->trackId ?? $attendance->track_id,
        ]);

        return SuccessUpdateAttendanceResource::make($attendance);
    }
}
