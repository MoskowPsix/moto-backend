<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetMembersForCoach\GetMembersForCoachCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface GetMembersForCoachActionContract
{
    public function __invoke($id, GetCouchesCommandRequest $request):
    NotUserPermissionResource|
    NotFoundResource|
    GetMembersForCoachCommandResource;
}
