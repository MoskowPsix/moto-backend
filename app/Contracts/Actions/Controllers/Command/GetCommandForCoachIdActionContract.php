<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\GetForCoachIdCommandRequest;
use App\Http\Resources\Command\GetCommandForCoach\SuccessGetCommandForCoachIdResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface GetCommandForCoachIdActionContract
{
    public function __invoke(GetForCoachIdCommandRequest $request): SuccessGetCommandForCoachIdResource|NotFoundResource|NotUserPermissionResource;
}
