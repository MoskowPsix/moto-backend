<?php

namespace App\Contracts\Actions\Controllers\Attendance;

use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\Attendance\Update\SuccessUpdateAttendanceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface UpdateAttendanceActionContract
{
    public function __invoke(int $id, UpdateAttendanceRequest $request): SuccessUpdateAttendanceResource|NotFoundResource|NotUserPermissionResource;
}
