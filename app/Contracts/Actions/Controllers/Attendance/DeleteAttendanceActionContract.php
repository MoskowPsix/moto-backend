<?php

namespace App\Contracts\Actions\Controllers\Attendance;

use App\Http\Requests\Attendance\DeleteAttendanceRequest;
use App\Http\Resources\Attendance\Delete\SuccessDeleteAttendanceResource;

interface DeleteAttendanceActionContract
{
    public function __invoke(int $id, DeleteAttendanceRequest $request): SuccessDeleteAttendanceResource;
}
