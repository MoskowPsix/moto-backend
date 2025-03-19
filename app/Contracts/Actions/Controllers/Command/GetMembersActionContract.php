<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetMember\SuccessGetMemberCommandResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetMembersActionContract
{
    public function __invoke(int $id, GetCouchesCommandRequest $request):
    NotFoundResource|
    SuccessGetMemberCommandResource;
}
