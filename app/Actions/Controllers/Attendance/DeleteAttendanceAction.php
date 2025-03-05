<?php

namespace App\Actions\Controllers\Attendance;

use App\Contracts\Actions\Controllers\Attendance\DeleteAttendanceActionContract;
use App\Http\Requests\Attendance\DeleteAttendanceRequest;
use App\Http\Resources\Attendance\Delete\SuccessDeleteAttendanceResource;
use App\Models\Attendance;

class DeleteAttendanceAction implements DeleteAttendanceActionContract
{
    public function __invoke(int $id, DeleteAttendanceRequest $request): SuccessDeleteAttendanceResource
    {
        $attendance = Attendance::find($id);
        $attendance->delete();
        return SuccessDeleteAttendanceResource::make($attendance);
    }
}
