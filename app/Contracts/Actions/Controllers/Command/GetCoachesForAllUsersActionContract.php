<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\GetCoachesForAllUsersRequest;
use App\Http\Resources\Command\GetCoachesForAll\SuccessGetCoachesForAllCommandResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetCoachesForAllUsersActionContract
{
    public function __invoke(int $id, GetCoachesForAllUsersRequest $request):
    SuccessGetCoachesForAllCommandResource|
    NotFoundResource;
}
