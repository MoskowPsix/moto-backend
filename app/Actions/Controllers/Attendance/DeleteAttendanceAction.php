<?php

namespace App\Actions\Controllers\Attendance;

use App\Contracts\Actions\Controllers\Attendance\DeleteAttendanceActionContract;
use App\Http\Requests\Attendance\DeleteAttendanceRequest;
use App\Http\Resources\Attendance\Delete\SuccessDeleteAttendanceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Attendance;

class DeleteAttendanceAction implements DeleteAttendanceActionContract
{
    public function __invoke(int $id, DeleteAttendanceRequest $request): SuccessDeleteAttendanceResource|NotFoundResource|NotUserPermissionResource
    {
        $attendance = Attendance::find($id);
        if (!isset($attendance)) {
            return NotFoundResource::make([]);
        }
        if ($attendance->user_id !== auth()->user()->id) {
            return NotUserPermissionResource::make([]);
        }
        $attendance->delete();
        return SuccessDeleteAttendanceResource::make($attendance);
    }
}
