<?php

namespace App\Contracts\Actions\Controllers\Attendance;

use App\Http\Requests\Attendance\CreateAttendanceRequest;
use App\Http\Resources\Attendance\Create\SuccessCreateAttendanceResource;

interface CreateAttendanceActionContract
{
    public function __invoke(CreateAttendanceRequest $request): SuccessCreateAttendanceResource;
}
