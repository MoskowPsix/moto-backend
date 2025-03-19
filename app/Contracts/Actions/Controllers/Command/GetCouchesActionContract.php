<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetCouches\SuccessGetCouchesCommandResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetCouchesActionContract
{
    public function __invoke(int $id, GetCouchesCommandRequest $request):
    NotFoundResource|
    SuccessGetCouchesCommandResource;
}
