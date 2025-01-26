<?php

namespace App\Contracts\Actions\Race;

use App\Http\Requests\Race\GetForIdRaceRequest;
use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;

interface GetForIdRaceActionContract
{
    public function __invoke(int $id, GetForIdRaceRequest $request): SuccessGetRaceForIdResource;

}
