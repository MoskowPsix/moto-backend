<?php

namespace App\Contracts\Actions\Controllers\RaceResult;

use App\Http\Requests\RaceResult\CreateRaceResultRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\RaceResult\Create\SuccessCreateRaceResultResource;

interface CreateRaceResultActionContract
{
    public function __invoke(int $id, CreateRaceResultRequest $request):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessCreateRaceResultResource;
}
